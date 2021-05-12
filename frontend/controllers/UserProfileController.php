<?php

namespace plathir\user\frontend\controllers;

use Yii;
use yii\web\Controller;
use plathir\user\common\models\profile\UserProfile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */

/**
 * @property \plathir\user\common\Module $module
 * 
 */
class UserProfileController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->layout = "main";
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-my-profile' => ['post'],
                    'uploadphoto' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',
                            'edit-my-profile',
                            'create-my-profile',
                            'delete-my-profile',
                            'uploadphoto'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            //Upload cropped image into temp directory
            'uploadphoto' => [
                'class' => '\plathir\cropper\actions\UploadAction',
                'width' => 600,
                'height' => 600,
                'temp_path' => $this->module->ProfileImageTempPath,
            ],
        ];
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
            if ($model->load(Yii::$app->request->post()) && ($user = $model->save())) {
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
            Yii::$app->getSession()->setFlash('danger', Yii::t('user','Profile already created !'));
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
                Yii::$app->getSession()->setFlash('success', Yii::t('user','Profile changed !'));
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
            Yii::$app->getSession()->setFlash('danger', Yii::t('user','Profile not exist !'));
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
        Yii::$app->getSession()->setFlash('success', Yii::t('user','Deleted !'));
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
