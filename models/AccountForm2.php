<?php

namespace plathir\user\models;

use plathir\user\models\User;
use yii\base\Model;

class AccountForm extends Model {

    /** @var string */
    public $email;

    /** @var string */
    public $username;

    /** @var string */
    public $new_password;

    /** @var string */
    public $current_password;

    public function rules() {
        return [

            ['username', 'required'],
            ['email', 'required'],
            ['email', 'email'],
            ['password', 'required'],
        ];
    }

}
