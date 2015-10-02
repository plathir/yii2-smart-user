<?php

namespace plathir\user\models\registration;

use plathir\user\models\account\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChangePasswordForm extends Model {

    public $id;
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

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
//    public function ChangePassword() {
//        if ($this->validate()) {
//            $upd_user = \Yii::$app->user->identity;
//            if (Yii::$app->security->validatePassword($this->password, $upd_user->password_hash)) {
//                $upd_user->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
//                if ($upd_user->save()) {
//                    return $upd_user;
//                }
//            }
//        }
//        return null;
//    }
}
