<?php

namespace plathir\user\backend\models\admin;

use plathir\user\common\models\account\User;
use Yii;

/**
 * Signup form
 */
class SetPasswordForm extends User {

    public $id;
    public $username;
    public $new_password;

    /**
     * @inheritdoc
     */
    public function __construct() {
        parent::__construct();
    }

    public function rules() {
        return [
            ['new_password', 'required'],
            ['new_password', 'string', 'min' => 6],
        ];
    }

    public function SaveNewPassword() {
        $user = User::findOne($this->id);
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
        if ($user->save()) {
            return true;
        } else {
            return false;
        }
    }

}
