<?php

namespace plathir\user\controllers;

use Yii;
use Yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\admin\AdminUsersSearch;
use plathir\user\models\admin\CreateUserForm;
use plathir\user\models\admin\CreateProfileForm;
use plathir\user\models\profile\UserProfile;
use plathir\user\models\account\User;
use plathir\user\models\admin\SetPasswordForm;
use yii\web\NotFoundHttpException;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;

/**
 * @property \plathir\user\Module $module
 * 
 */
class AdminController extends Controller {

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
                            'delete-profile',
                            'delete-image'
                        ],
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

        if ($model->load(Yii::$app->request->post())) {

            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            $ImageName = $model->id;

            if ($model->file) {
                $model->file->saveAs(\yii::getAlias($this->module->ProfileImagePath) . '/' . $ImageName . '.' . $model->file->extension);
                $model->profile_image = $ImageName . '.' . $model->file->extension;
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Profile created !');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                
            }
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
                    'module' => $this->module,
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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->update()) {
                Yii::$app->getSession()->setFlash('success', 'User updated !');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('update', [
                            'account' => $model,
                            'module' => $this->module,
                ]);
            }
        } else {
            return $this->render('update', [
                        'account' => $model,
                        'module' => $this->module,
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

        if ($model->load(Yii::$app->request->post())) {

            if ($model->profile_image == '') {

                $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
                $ImageName = $model->id;
                if ($model->file) {
                    $model->file->saveAs(\yii::getAlias($this->module->ProfileImagePath) . '/' . $ImageName . '.' . $model->file->extension);
                    $model->profile_image = $ImageName . '.' . $model->file->extension;
                }
            }

            if ($model->update()) {
                Yii::$app->getSession()->setFlash('success', 'User Profile updated !');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('update-profile', [
                            'profile' => $model,
                            'module' => $this->module,
                ]);
            }
        } else {
            return $this->render('update-profile', [
                        'profile' => $model,
                        'module' => $this->module,
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
        if ($this->findModel($id)->delete()) {
            if ($this->findModelProfile($id) != null) {
                if ($this->findModelProfile($id)->delete()) {
                    Yii::$app->getSession()->setFlash('success', 'User Account and profile deleted !');
                }
            } else {
                Yii::$app->getSession()->setFlash('success', 'User Account deleted !');
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', 'User cannot delete !');
        }
        return $this->redirect(['index']);
    }

    /**
     * Delete Profile data
     * @param type $id
     * @return type
     */
    public function actionDeleteProfile($id) {
        $image = $this->findModelProfile($id)->profile_image;
        if ($this->findModelProfile($id)->delete()) {
            if ($image) {
                unlink($this->module->ProfileImagePath . '/' . $image);
            }
            Yii::$app->getSession()->setFlash('success', 'User profile deleted !');
        } else {
            Yii::$app->getSession()->setFlash('danger', 'User Profile cannot delete !');
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * 
     * @param type $id
     * @return type
     * @throws BadRequestHttpException
     */
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

        if ($user = User::findOne($id)) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                Yii::$app->getSession()->setFlash('success', 'Send email with new password token url');
                $mailer = \Yii::$app->mailer;
                $mailer->viewPath = $this->viewPath . '\mail';
                $mailer->getView()->theme = \Yii::$app->view->theme;
                $mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($user->email)
                        ->setSubject('Password reset for ' . \Yii::$app->name)
                        ->send();
                return $this->redirect(['view', 'id' => $id]);
            }
        }
// need my code here
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSetPassword($id) {
        $model = new SetPasswordForm();
        $model->id = $id;
        if ($user = User::findOne($id)) {
            if ($model->load(Yii::$app->request->post()) && $model->SaveNewPassword()) {
                Yii::$app->getSession()->setFlash('success', 'new password set');
                return $this->render('view', ['account' => $this->findModel($model->id),
                            'profile' => $this->findModelProfile($model->id),
                ]);
            } else {
                return $this->render('set-password', ['model' => $model]);
            }
        }
    }

    public function actionDeleteImage($id) {
        $model = $this->findModelProfile($id);
        if ($model) {
            //  unlink($this->module->ProfileImagePath . '/' . $model->profile_image);
            $model->profile_image = '';
            $model->file = '';
            $model->update();
        }
        return $this->redirect(['update-profile', 'id' => $id]);
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
