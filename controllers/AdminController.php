<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\AdminUsers;
use plathir\user\models\AdminUsersSearch;
use plathir\user\models\User;
use plathir\user\models\CreateUserForm;

class AdminController extends Controller {

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
                        'actions' => ['create', 'index', 'view', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [ 'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate() {
        $model = new CreateUserForm();
        if ($model->load(Yii::$app->request->post()) && $new_user = $model->signup()) {
            return $this->redirect(['view', 'id' => $new_user->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id) {
        return $this->render('update', [
                    'model' => $this->findModel($id),
        ]);
    }
    
    public function actionIndex() {
        $searchModel = new AdminUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
