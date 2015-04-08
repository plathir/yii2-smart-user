<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\AccountForm;
use plathir\user\models\User;
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
                        'actions' => ['index','edit', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    
       public function actionIndex() {
        $model = $this->findModel(\Yii::$app->user->identity->id);
        return $this->render('index', [
                    'model' => $model,
        ]);
    }
    
        public function actionEdit() {
        $model = $this->findModel(\Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->edit()) {
                Yii::$app->getSession()->setFlash('success', 'Account changed !');
                return $this->refresh();
            }
        }

        return $this->render('edit', [
                    'model' => $model,
        ]);
    }
    
        public function actionChangePassword() {
        $model = $this->findModelChangePassword(\Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->ChangePassword()) {
                    Yii::$app->getSession()->setFlash('success', 'Password changed !');
                    return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Password cannot change ! check your entries ');
            }
        }
        return $this->render('change_password', [
                    'model' => $model,
        ]);
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
