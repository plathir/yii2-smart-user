<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\admin\AdminUsersSearch;
use plathir\user\models\admin\CreateUserForm;
use plathir\user\models\admin\CreateProfileForm;
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
                    'delete-profile' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'create',
                            'index',
                            'view',
                            'delete',
                            'update',
                            'reset-password', 
                            'set-password', 
                            'activate',
                            'update-profile',
                            'create-profile',
                            'delete-profile'
                            
                        ],
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

    /**
     * Create Account
     * @return type
     */
    public function actionCreate() {
        $model = new CreateUserForm();
        $model->setPassword($model->password);
        $model->generateAuthKey();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', ['account' => $this->findModel($model->id),
                        'profile' => $this->findModelProfile($model->id),
            ]);
        } else {
            return $this->render('create', [
                        'account' => $model,
            ]);
        }
    }

    /**
     * Create Profile for user account
     * 
     * @param type $id
     * @return type
     */
    public function actionCreateProfile($id) {
        $model = new CreateProfileForm();
        $model->id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Profile created !');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('create-profile', [
                        'profile' => $model,
            ]);
        }
    }

    /**
     * View Account and profile data
     * 
     * @param type $id
     * @return type
     */
    public function actionView($id) {
        return $this->render('view', [
                    'account' => $this->findModel($id),
                    'profile' => $this->findModelProfile($id),
        ]);
    }

    /**
     * Update user Account 
     * 
     * @param type $id
     * @return type
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->getSession()->setFlash('success', 'User updated !');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                        'account' => $model,
            ]);
        }
    }

    /**
     * Update user Profile
     * @param type $id
     * @return type
     */
    public function actionUpdateProfile($id) {
        $model = $this->findModelProfile($id);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->getSession()->setFlash('success', 'User Profile updated !');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update-profile', [
                        'profile' => $model,
            ]);
        }
    }

    /**
     *  Index of Users
     * @return type
     */
    public function actionIndex() {
        $searchModel = new AdminUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *  Delete User Account ( and Profile data )
     * 
     * @param type $id
     * @return type
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        $this->findModelProfile($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Delete Profile data
     * @param type $id
     * @return type
     */
    public function actionDeleteProfile($id) {
        $this->findModelProfile($id)->delete();
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionActivate($id) {
        $user = $this->findModel($id);
        $token = $user->activate_token;
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

    
    
    public function actionResetPassword($id) {
            Yii::$app->getSession()->setFlash('success', 'Send email with new password token url');

            // need my code here
            return $this->redirect(['view', 'id' => $id]);            
    }

    public function actionSetPassword($id) {
            Yii::$app->getSession()->setFlash('success', 'new password entry');

            // need my code here
            return $this->redirect(['view', 'id' => $id]);            
    }
    
    /**
     * find User Account Model
     * @param type $id
     * @return type
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        if (($model = CreateUserForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Find User Profile data
     * @param type $id
     * @return boolean
     */
    protected function findModelProfile($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

}
