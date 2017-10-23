<?php

namespace plathir\user\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\common\models\account\AccountForm;
use plathir\user\common\models\account\User;
use plathir\user\common\models\profile\UserProfile;
use plathir\user\common\models\registration\ChangePasswordForm;

/**
 * @property \plathir\user\common\Module $module
 * 
 */
class AccountController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
    }

    /** @inheritdoc */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['my', 'edit', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    ['actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionMy() {
        if (\yii::$app->user->can('UserAccountMy')) {
            $account = User::findIdentity(\Yii::$app->user->identity->id);
            $profile = UserProfile::find()
                    ->where(['id' => \Yii::$app->user->identity->id])
                    ->one();

            //        ::search(['id' => \Yii::$app->user->identity->id ]);

            return $this->render('my', [
                        'account' => $account,
                        'profile' => $profile,
                        'roles' => \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id),
                        'module' => $this->module
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException('No Permission to view my data ');
        }
    }

    public function actionEdit() {
        if (\yii::$app->user->can('UserAccountEdit')) {
            $model = $this->findModel(\Yii::$app->user->identity->id);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->ValidateAndSave()) {
                    Yii::$app->getSession()->setFlash('success', 'Account changed !');
                    return $this->redirect(['/user/account/my']);
                } else {
                    return $this->render('edit', [
                                'model' => $model,
                    ]);
                }
            } else {
                return $this->render('edit', [
                            'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException('No Permission to edit Account data');
        }
    }

    public function actionChangePassword() {
        if (\yii::$app->user->can('UserAccountChangePassword')) {
            $model = $this->findModelChangePassword(\Yii::$app->user->identity->id);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->ChangePassword()) {
                    Yii::$app->getSession()->setFlash('success', 'Password changed !');
                    //  return $this->refresh();
                    return $this->redirect(['account/my']);
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Password cannot change ! check your entries ');
                    return $this->render('change_password', [
                                'model' => $model,
                    ]);
                }
            } else {
                return $this->render('change_password', [
                            'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException('No Permission to change password');
        }
    }

    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            $new_model = new AccountForm();
            $new_model->username = $model->username;
            $new_model->email = $model->email;
            $new_model->timezone = $model->timezone;

            return $new_model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelChangePassword($id) {
        if (($model = User::findOne($id)) !== null) {
            $new_model = new ChangePasswordForm();
            $new_model->username = $model->username;
            $new_model->email = $model->email;
            return $new_model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
