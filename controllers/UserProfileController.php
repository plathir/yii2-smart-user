<?php

namespace plathir\user\controllers;

use Yii;
use plathir\user\models\UserProfile;
use plathir\user\models\UserProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-my-profile' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'edit-my-profile', 'create-my-profile', 'delete-my-profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateMyProfile() {
        $model = $this->findModel(\Yii::$app->user->identity->id);
        if ($model == null) {
            $model = new UserProfile();
            $model->id = \Yii::$app->user->identity->id;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['account/my']);
            } else {
                if (\Yii::$app->request->isAjax) {
                    return $this->renderAjax('create-my-profile', [
                                'model' => $model,
                    ]);
                } else {
                    return $this->render('create-my-profile', [
                                'model' => $model,
                    ]);
                }
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', 'profile already created!');
            return $this->actionEditMyProfile();
        }
    }

    /**
     * Edit my Profile
     * 
     */
    public function actionEditMyProfile() {
        $model = $this->findModel(\Yii::$app->user->identity->id);
        if ($model != null) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['account/my']);
            } else {


                if (\Yii::$app->request->isAjax) {
                    return $this->renderAjax('edit-my-profile', [
                                'model' => $model,
                    ]);
                } else {
                    return $this->render('edit-my-profile', [
                                'model' => $model,
                    ]);
                }
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', 'profile not exist !');
            return $this->actionCreateMyProfile();
        }
    }

    /**
     * Deletes an existing UserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteMyProfile() {
        $this->findModel(\Yii::$app->user->identity->id)->delete();
        Yii::$app->getSession()->setFlash('success', 'Deleted !');
        return $this->redirect(['account/my']);
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
            //throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    


        }
