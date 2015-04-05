<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\AccountForm;
use plathir\user\models\User;

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
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays page where user can update account settings (username, email or password).
     * @return string|\yii\web\Response
     */
    public function actionEdit() {
        $AccountModel = new AccountForm();

        //$AccountModel = $this->findModel(\Yii::$app->user->identity->id);
        
        if ($AccountModel->load(Yii::$app->request->post())) {
            return $this->goHome;
        } else {
            return $this->render('edit', [
                        'model' => $AccountModel,
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

}
