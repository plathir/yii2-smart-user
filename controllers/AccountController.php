<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\AccountForm;
use plathir\user\models\User;
use plathir\user\models\UserProfile;
use plathir\user\models\ChangePasswordForm;

class AccountController extends Controller {

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
                ],
            ],
        ];
    }

    public function actionMy() {

        $account = User::findIdentity(\Yii::$app->user->identity->id);
        $profile = UserProfile::find()
                ->where(['id' => \Yii::$app->user->identity->id])
                ->one();

        //        ::search(['id' => \Yii::$app->user->identity->id ]);


        return $this->render('my', [
                    'account' => $account,
                    'profile' => $profile,
        ]);
    }

    public function actionEdit() {
        $model = $this->findModel(\Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post()) && ($model->edit())) {
            Yii::$app->getSession()->setFlash('success', 'Account changed !');
            //return $this->refresh();
            return $this->redirect(['account/my']);
        } else {
            if (\Yii::$app->request->isAjax) {
                return $this->renderAjax('edit', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('edit', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionChangePassword() {
        $model = $this->findModelChangePassword(\Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->ChangePassword()) {
                Yii::$app->getSession()->setFlash('success', 'Password changed !');
                //  return $this->refresh();
                return $this->redirect(['account/my']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Password cannot change ! check your entries ');
            }
        }
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('change_password', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('change_password', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            $new_model = new AccountForm();
            $new_model->username = $model->username;
            $new_model->email = $model->email;

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
