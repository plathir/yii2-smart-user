<?php

namespace plathir\user\frontend\controllers;

use Yii;
use plathir\user\frontend\models\registration\PasswordResetRequestForm;
use plathir\user\frontend\models\registration\ResetPasswordForm;
use plathir\user\frontend\models\registration\SignupForm;
use plathir\user\frontend\models\registration\ActivateUser;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;

class RegistrationController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->layout = "main";
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signup', 'user-activation'],
                'rules' => [
                    [
                        'actions' => ['signup', 'user-activation'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($this->assignPermissions($user)) {
                    if ($model->sendEmail()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Check your email for account Activation.'));
                        return $this->goHome();
                    } else {
                        Yii::$app->getSession()->setFlash('error', Yii::t('user', 'problem with email'));
                    }
                }
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('user', ' Signup Error !'));
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function assignPermissions($user) {
        $auth = Yii::$app->authManager;
        $defaultRoles = explode(',', $this->module->settings->getSettings('DefaultRoles'));
        foreach ($defaultRoles as $role) {
            // Hard Code for extra securiry  
            if ($role != 'sysadmin' && $role != 'UserAdmin') {
                $newRole = $auth->getRole($role);
                $auth->assign($newRole, $user->getId());
            }
        }
        return true;
    }

    public function actionUserActivation($token) {
        try {
            $model = new ActivateUser($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->activate()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User activated !'));

            if (Yii::$app->getUser()->login($model->user)) {
                return $this->goHome();
            }
        }

        Yii::$app->getSession()->setFlash('error', Yii::t('user', 'activation incomplete !.'));
        return $this->goHome();
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('user', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'New password was saved.'));

            return $this->redirect('../security/login');
            //  return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
