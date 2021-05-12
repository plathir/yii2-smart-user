<?php

namespace plathir\user\frontend\models\registration;

use plathir\user\common\models\account\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChangePasswordForm extends Model {

    public $username;
    public $email;
    public $new_password;
    public $new_password_repeat;
    public $password;
    public $viewPath = '@vendor/plathir/yii2-smart-user/common/views/mail';

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
            ['new_password_repeat', 'required'],
            ['new_password_repeat', 'string', 'min' => 6],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password'],            
        ];
    }
    public function attributeLabels() {
        return [
            'username' => Yii::t('user', 'User Name'),
            'password' => Yii::t('user', 'Current Password'),
            'new_password' => Yii::t('user', 'New Password'),
            'new_password_repeat' => Yii::t('user', 'Repeat New Password'),
            

            
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function ChangePassword() {
        if ($this->validate()) {

            $upd_user = \Yii::$app->user->identity;
            if ($this->new_password != '' && Yii::$app->security->validatePassword($this->password, $upd_user->password_hash)) {
                $upd_user->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
                if ($upd_user->save()) {
                    return $upd_user;
                }
            }
        }
        return null;
    }

}
