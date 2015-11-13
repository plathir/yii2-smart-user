<?php

namespace plathir\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class AuthController extends Controller {

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
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create-user-permissions', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreateUserPermissions() {

        $auth = Yii::$app->authManager;

        // add "AdminCreateUser" permission
        $AdminIndexUser = $auth->createPermission('AdminIndexUser');
        $AdminIndexUser->description = 'Admin Index of users';
        $auth->add($AdminIndexUser);

        // add "AdminCreateUser" permission
        $AdminCreateUser = $auth->createPermission('AdminCreateUser');
        $AdminCreateUser->description = 'Admin Create a user';
        $auth->add($AdminCreateUser);

        // add "AdminUpdateUser" permission
        $AdminUpdateUser = $auth->createPermission('AdminUpdateUser');
        $AdminUpdateUser->description = 'Admin Update user';
        $auth->add($AdminUpdateUser);

        // add "AdminViewUser" permission
        $AdminViewUser = $auth->createPermission('AdminViewUser');
        $AdminViewUser->description = 'Admin View user';
        $auth->add($AdminViewUser);

        // add "AdminDeleteUser" permission
        $AdminDeleteUser = $auth->createPermission('AdminDeleteUser');
        $AdminDeleteUser->description = 'Admin Delete user';
        $auth->add($AdminDeleteUser);

        // add "AdminResetUserPassword" permission
        $AdminResetUserPassword = $auth->createPermission('AdminResetUserPassword');
        $AdminResetUserPassword->description = 'Admin Reset user password';
        $auth->add($AdminResetUserPassword);

        // add "AdminSetUserPassword" permission
        $AdminSetUserPassword = $auth->createPermission('AdminSetUserPassword');
        $AdminSetUserPassword->description = 'Admin Set user password';
        $auth->add($AdminSetUserPassword);

        // add "AdminCreateUserProfile" permission
        $AdminCreateUserProfile = $auth->createPermission('AdminCreateUserProfile');
        $AdminCreateUserProfile->description = 'Admin Create user profile';
        $auth->add($AdminCreateUserProfile);

        // add "AdminUpdateUserProfile" permission
        $AdminUpdateUserProfile = $auth->createPermission('AdminUpdateUserProfile');
        $AdminUpdateUserProfile->description = 'Admin Update user profile';
        $auth->add($AdminUpdateUserProfile);

        // add "AdminDeleteUserProfile" permission
        $AdminDeleteUserProfile = $auth->createPermission('AdminDeleteUserProfile');
        $AdminDeleteUserProfile->description = 'Admin Delete user profile';
        $auth->add($AdminDeleteUserProfile);

        // add "AdminFileUpload" permission
        $AdminFileUpload = $auth->createPermission('AdminFileUpload');
        $AdminFileUpload->description = 'Admin Delete user profile';
        $auth->add($AdminFileUpload);


        // add "UserAdmin" role and give this role the "createPost" permission
        $UserAdmin = $auth->createRole('UserAdmin');
        $UserAdmin->description = 'User Administrator role';
        $auth->add($UserAdmin);
        $auth->addChild($UserAdmin, $AdminIndexUser);
        $auth->addChild($UserAdmin, $AdminCreateUser);
        $auth->addChild($UserAdmin, $AdminUpdateUser);
        $auth->addChild($UserAdmin, $AdminViewUser);
        $auth->addChild($UserAdmin, $AdminDeleteUser);
        $auth->addChild($UserAdmin, $AdminResetUserPassword);
        $auth->addChild($UserAdmin, $AdminSetUserPassword);
        $auth->addChild($UserAdmin, $AdminCreateUserProfile);
        $auth->addChild($UserAdmin, $AdminUpdateUserProfile);
        $auth->addChild($UserAdmin, $AdminDeleteUserProfile);
        $auth->addChild($UserAdmin, $AdminFileUpload);


        // add "UserAccountMy" permission
        $UserAccountMy = $auth->createPermission('UserAccountMy');
        $UserAccountMy->description = 'User My data';
        $auth->add($UserAccountMy);

        // add "UserAccountEdit" permission
        $UserAccountEdit = $auth->createPermission('UserAccountEdit');
        $UserAccountEdit->description = 'User edit account';
        $auth->add($UserAccountEdit);

        // add "UserAccountChangePassword" permission
        $UserAccountChangePassword = $auth->createPermission('UserAccountChangePassword');
        $UserAccountChangePassword->description = 'User change password';
        $auth->add($UserAccountChangePassword);

        // add "UserAccountIndex" permission
        $UserAccountIndex = $auth->createPermission('UserAccountIndex');
        $UserAccountIndex->description = 'User Accounts index';
        $auth->add($UserAccountIndex);

        // add "User" role and give this role the "createPost" permission
        $User = $auth->createRole('User');
        $User->description = 'User role';
        $auth->add($User);

        $auth->addChild($User, $UserAccountMy);
        $auth->addChild($User, $UserAccountEdit);
        $auth->addChild($User, $UserAccountChangePassword);
        $auth->addChild($User, $UserAccountIndex);

        $auth->assign($UserAdmin, 1); // Assign UserAdmin Role to userid : 1 ( admin ), change code to get admin user from module paremeters
        $auth->assign($User, 1); // Assign User Role to userid : 1 ( admin ), change code to get admin user from module paremeters
    }

    public function actionIndex() {
        
    }

}
