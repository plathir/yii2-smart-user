<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\admin\AdminUsersSearch;
use plathir\user\models\admin\CreateUserForm;
//use plathir\user\models\ActivateUser;
use plathir\user\models\profile\UserProfile;
use yii\web\NotFoundHttpException;

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
            return $this->render('view', 
               ['account' => $this->findModel($model->id),
                 'profile' => $this->findModelProfile($model->id),                           
            ]);
        } else {
            return $this->render('create', [
                        'account' => $model,
            ]);
        }
    }

    public function actionView($id) {
        return $this->render('view', [
                    'account' => $this->findModel($id),
                    'profile' => $this->findModelProfile($id),
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->getSession()->setFlash('success', 'User updated !');
            return $this->render('view', [
                        'account' => $model,
                        'profile' => $this->findModelProfile($model->id),
            ]);
        } else {
            return $this->render('update', [
                        'account' => $model,
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

        protected function findModelProfile($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
       }
    }
}
