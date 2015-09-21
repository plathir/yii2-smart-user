<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\AdminUsersSearch;
use plathir\user\models\CreateUserForm;
use plathir\user\models\ActivateUser;

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
                        'actions' => ['create', 'index', 'view', 'delete', 'update', 'activate'],
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
        $model->setPassword($model->password);
        $model->generateAuthKey();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', ['model' => $this->findModel($model->id)
            ]);
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->render('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
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

    public function actionActivate($id) {
        $user = $this->findModel($id);
        $token = $user->activate_token;
//        print_r($user);
//        die();
        
        if ($token !== null) {
            try {
                $model = new ActivateUser($token);
            } catch (InvalidParamException $e) {
                throw new BadRequestHttpException($e->getMessage());
            }

            if ($model->activate()) {
                Yii::$app->getSession()->setFlash('success', 'User activated !');
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'activation incomplete !.');
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', 'user already active !.');
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id) {
        if (($model = CreateUserForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
