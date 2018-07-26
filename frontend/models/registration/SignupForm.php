<?php

namespace plathir\user\frontend\models\registration;

use plathir\user\common\models\account\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */

/**
 * @property \plathir\user\common\Module $module
 * 
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $viewPath = '@vendor/plathir/yii2-smart-user/common/views/mail';
    public $terms;
    public $timezone;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['terms', 'required', 'requiredValue' => 1, 'message' => 'Need to Agree to the terms'],
            ['username', 'unique', 'targetClass' => '\plathir\user\common\models\account\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['timezone', 'string'],
            ['email', 'unique', 'targetClass' => '\plathir\user\common\models\account\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
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
            $user->status = User::STATUS_INACTIVE;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->timezone = $this->timezone;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        } else {
            return false;
            //            print_r($this->getErrors());         
            //            die();
        }

        return null;
    }

    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_INACTIVE,
                    //'status' => User::STATUS_ACTIVE,                    
                    //               'activate_token' => null,
                    'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isActivateTokenValid($user->password_reset_token)) {
                $user->generateActivateToken();
            }
            if ($user->save()) {
                $mailer = \Yii::$app->mailer;
                if (!Yii::$app->controller->module->settings->getSettings('RegistrationTemplate')) {

                    $mailer->viewPath = $this->viewPath;
                    $mailer->getView()->theme = \Yii::$app->view->theme;
                    return $mailer->compose(['html' => 'ActivateToken-html', 'text' => 'ActivateToken-text'], ['user' => $user])
                                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                                    ->setTo($this->email)
                                    ->setSubject('Activate Account for ' . \Yii::$app->name)
                                    ->send();
                } else {
                    $activateLink = Yii::$app->urlManager->createAbsoluteUrl(['user/registration/user-activation', 'token' => $user->activate_token]);
                    return $mailer->compose()
                                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                                    ->setTo($this->email)
                                    ->setSubject('Activate Account for ' . \Yii::$app->name)
                                    ->setHtmlBody(Yii::$app->templates->getTemplate(Yii::$app->controller->module->settings->getSettings('RegistrationTemplate'), [
                                                '{user}' => $user->username,
                                                '{activate_link}' => $activateLink,
                                                    ]
                                            )
                                    )
                                    ->send();
                }
            }
        }

        return false;
    }

    public function getTimezoneslist() {
        $items = \DateTimeZone::listIdentifiers();
        $newItems = [];
        $key_h = 0;

        foreach ($items as $key => $value) {
            $key_h = $key_h + 1;
            $newItems[$key_h]['id'] = $key_h;
            $newItems[$key_h]['timezone'] = $value;
        };
        $timezonesList = \yii\helpers\ArrayHelper::map($newItems, 'timezone', 'timezone');
        return $timezonesList;
    }

}
