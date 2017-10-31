<?php

namespace plathir\user\frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\frontend\models\security\LoginForm;
use plathir\user\common\models\security\Auth;
use plathir\user\common\models\account\User;

class SecurityController extends Controller {
    
        public function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->layout = "main";
    }


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
                        'actions' => ['login', 'logout', 'auth'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['login', 'logout', 'auth'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionLogin() {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findIdentity(Yii::$app->user->identity->id);
            $user->touch('last_visited');
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }


    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function onAuthSuccess($client) {

        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = User::findOne(['id' => $auth->user_id]);
                Yii::$app->user->login($user);
            } else { // signup
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);

                    $user = new User([
                        'username' => $attributes['name'],
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $authManager = Yii::$app->authManager;
                        $authorRole = $authManager->getRole('User');
                        $authManager->assign($authorRole, $user->id);

                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string) $attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    public function saveLoginInfo($userID) {
        
    }

}
