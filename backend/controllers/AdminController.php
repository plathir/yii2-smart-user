<?php

namespace plathir\user\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\backend\models\admin\AdminUsersSearch;
use plathir\user\backend\models\admin\CreateUserForm;
use plathir\user\common\models\profile\UserProfile;
use plathir\user\common\models\account\User;
use plathir\user\backend\models\admin\SetPasswordForm;
use yii\web\NotFoundHttpException;

/**
 * @property \plathir\user\Module $module
 * 
 */
class AdminController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->layout = "main";
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
                            'delete-image',
                            'uploadphoto'
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
     * Create Account
     * @return type
     */
    public function actionCreate() {
        if (\yii::$app->user->can('AdminCreateUser')) {
            $model = new CreateUserForm();
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->activate_token = '';
            $model->last_visited = gmmktime();
//            $tzone = function() {
//              return '<script type="text/javascript">
//                       var tZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
//               </script>';
//            };

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $auth = Yii::$app->authManager;
                $defaultRoles = explode(',', $this->module->settings->getSettings('DefaultRoles'));
                foreach ($defaultRoles as $role) {
                    // Hard Code for extra securiry  
                    if ($role != 'sysadmin' && $role != 'UserAdmin') {
                        $newRole = $auth->getRole($role);
                        $auth->assign($newRole, $model->id);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'account' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to create user'));
        }
    }

    /**
     * Create Profile for user account
     * 
     * @param type $id
     * @return type
     */
    public function actionCreateProfile($id) {
        if (\yii::$app->user->can('AdminCreateUserProfile')) {
            $model = new UserProfile();
            $model->id = $id;
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('user','Profile created !'));
                    return $this->redirect(['view', 'id' => $id]);
                } else {
                    Yii::$app->getSession()->setFlash('danger', Yii::t('user','Profile cannot create !'));
                }
            } else {
                return $this->render('create-profile', [
                            'profile' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to create user profile'));
        }
    }

    /**
     * View Account and profile data
     * 
     * @param type $id
     * @return type
     */
    public function actionView($id) {
        if (\yii::$app->user->can('AdminViewUser')) {
            return $this->render('view', [
                        'account' => $this->findModel($id),
                        'profile' => $this->findModelProfile($id),
                        'roles' => \Yii::$app->authManager->getRolesByUser($id),
                        'module' => $this->module,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to View user'));
        }
    }

    /**
     * Update user Account 
     * 
     * @param type $id
     * @return type
     */
    public function actionUpdate($id) {
        if (\yii::$app->user->can('AdminUpdateUser')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($model->update()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('user','User updated !'));
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
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to Update user'));
        }
    }

    /**
     * Update user Profile
     * @param type $id
     * @return type
     */
    public function actionUpdateProfile($id) {
        if (\yii::$app->user->can('AdminUpdateUserProfile')) {
            $model = $this->findModelProfile($id);
            if ($model->load(Yii::$app->request->post())) {

                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('user','Profile changed !'));
                    return $this->redirect(['view', 'id' => $id]);
                } else {
                    Yii::$app->getSession()->setFlash('danger', Yii::t('user','Profile cannot change !'));
                    return $this->redirect(['update', 'id' => $id]);
                }
            } else {
                return $this->render('update-profile', [
                            'profile' => $model,
                            'module' => $this->module,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to Update Profile'));
        }
    }

    /**
     *  Index of Users
     * @return type
     */
    public function actionIndex() {
        if (\yii::$app->user->can('AdminIndexUser')) {
            $searchModel = new AdminUsersSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to view User Index'));
        }
    }

    /**
     *  Delete User Account ( and Profile data )
     * 
     * @param type $id
     * @return type
     */
    public function actionDelete($id) {
        if (\yii::$app->user->can('AdminDeleteUser')) {
            if ($this->findModel($id)->delete()) {
                if ($this->findModelProfile($id) != null) {
                    if ($this->findModelProfile($id)->delete()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('user','User Account and profile deleted !'));
                    }
                } else {
                    Yii::$app->getSession()->setFlash('success', Yii::t('user','User Account deleted !'));
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('user','User cannot delete !'));
            }
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user','No Permission to Delete User '));
        }
    }

    /**
     * Delete Profile data
     * @param type $id
     * @return type
     */
    public function actionDeleteProfile($id) {
        $image = $this->findModelProfile($id)->profile_image;
        if ($this->findModelProfile($id)->delete()) {
            if (file_exists($this->module->ProfileImagePathPreview . '/' . $image)) {
                unlink($this->module->ProfileImagePathPreview . '/' . $image);
            }
            Yii::$app->getSession()->setFlash('success', Yii::t('user','User profile deleted !'));
        } else {
            Yii::$app->getSession()->setFlash('danger', Yii::t('user','User Profile cannot delete !'));
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
                Yii::$app->getSession()->setFlash('success', Yii::t('user','User activated !'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('user','activation incomplete !.'));
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('user','user already active !.'));
            return $this->redirect(['index']);
        }
    }

    public function actionResetPassword($id) {

        if ($user = User::findOne($id)) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('user','Send email with new password token url'));
                $mailer = \Yii::$app->mailer;
                $mailer->viewPath = $this->viewPath . '\mail';
                $mailer->getView()->theme = \Yii::$app->view->theme;
                $mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($user->email)
                        ->setSubject(Yii::t('user','Password reset for ') . \Yii::$app->name)
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
            $model->username = $user->username;
        }

        if ($user = User::findOne($id)) {
            if ($model->load(Yii::$app->request->post()) && $model->SaveNewPassword()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('user','new password set'));
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('set-password', ['model' => $model]);
            }
        }
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
            throw new NotFoundHttpException(Yii::t('user','The requested page does not exist.'));
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
