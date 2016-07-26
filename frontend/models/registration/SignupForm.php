<?php

namespace plathir\user\frontend\models\registration;

use plathir\user\common\models\account\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $viewPath = '@vendor/plathir/yii2-smart-user/common/views/mail';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\plathir\user\common\models\account\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\plathir\user\common\models\account\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('User');
                $auth->assign($authorRole, $user->getId());
                return $user;
            }
        }

        return null;
    }

    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    //               'activate_token' => null,
                    'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isActivateTokenValid($user->password_reset_token)) {
                $user->generateActivateToken();
            }
            if ($user->save()) {
                $mailer = \Yii::$app->mailer;
                $mailer->viewPath = $this->viewPath;
                $mailer->getView()->theme = \Yii::$app->view->theme;
                return $mailer->compose(['html' => 'ActivateToken-html', 'text' => 'ActivateToken-text'], ['user' => $user])
                                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                                ->setTo($this->email)
                                ->setSubject('Activate Account for ' . \Yii::$app->name)
                                ->send();
            }
        }

        return false;
    }

}
