<?php

namespace plathir\user\models;

use plathir\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChangePasswordForm extends Model {

    public $username;
    public $email;
    public $new_password;
    public $password;
    public $viewPath = '@vendor/plathir/yii2-smart-user/views/mail';

    /**
     * @inheritdoc
     */

    /** @var User */
    private $_user;

    /** @return User */
    public function getUser() {
        if ($this->_user == null) {
            $this->_user = \Yii::$app->user->identity;
        }
        return $this->_user;
    }

    public function __construct() {
        $this->setAttributes([
            'username' => $this->user->username,
            'email' => $this->user->email
                ], false);
        parent::__construct();
    }

    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['new_password', 'required'],
            ['new_password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function ChangePassword() {
        if ($this->validate()) {
//            $upd_user = \Yii::$app->user->identity;
//            $upd_user->username = $this->username;
//            $upd_user->email = $this->email;
//            $upd_user->setPassword($this->password);
//            $upd_user->generateAuthKey();
            if ($upd_user->save()) {
                return $upd_user;
            }
        }

        return null;
    }

}
