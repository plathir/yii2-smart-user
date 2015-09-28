<?php

namespace plathir\user\models\account;

use plathir\user\models\account\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AccountForm extends Model {

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
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\plathir\user\models\account\User',
                'message' => 'This username already been taken.',
                'when' => function ($model, $attribute) {
                    return $this->user->$attribute != $model->$attribute;
                },
            ],
            [ 'email', 'unique',
                'targetClass' => '\plathir\user\models\account\User',
                'message' => 'This email already been taken.',
                'when' => function ($model, $attribute) {
                    return $this->user->$attribute != $model->$attribute;
                },
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function ValidateAndSave() {
//         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//         return $this->validate();
        if ($this->validate()) {
            $upd_user = \Yii::$app->user->identity;
            $upd_user->username = $this->username;
            $upd_user->email = $this->email;
//            $upd_user->setPassword($this->password);
            $upd_user->generateAuthKey();
            if ($upd_user->save()) {
                return true;
            }
        } 
        return null;
    }

}

