<?php

namespace plathir\user\controllers;

use Yii;
use plathir\user\models\PasswordResetRequestForm;
use plathir\user\models\ResetPasswordForm;
use plathir\user\models\SignupForm;
use plathir\user\models\User;
use plathir\user\models\ActivateUser;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;


class RegistrationController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'user-activation'],
                'rules' => [
                    [
                        'actions' => ['signup', 'user-activation'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ($model->sendEmail()) {
                    Yii::$app->getSession()->setFlash('success', 'Check your email for account Activation.');
                    return $this->goHome();
                } else {
                    Yii::$app->getSession()->setFlash('error', 'problem woth email');
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionUserActivation($token) {
         try {
            $model = new ActivateUser($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->activate()) {
            Yii::$app->getSession()->setFlash('success', 'User activated !');
            
                if (Yii::$app->getUser()->login($model->user)) {
                    return $this->goHome();
                }
        }
        
            Yii::$app->getSession()->setFlash('error', 'activation incomplete !.');
            return $this->goHome();
        
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
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
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
