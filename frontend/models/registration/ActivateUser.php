<?php

namespace plathir\user\frontend\models\registration;

use plathir\user\common\models\account\User;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Password reset form
 */
class ActivateUser extends Model {

    public $password;

    /**
     * @var \common\models\User
     */
    public $user;

    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('user','Activate token cannot be blank.'));
        }

        $this->user = User::findByActivateToken($token);
        
        if (!$this->user) {
            throw new InvalidParamException(Yii::t('user','Wrong activate token.'));
        } else {
            parent::__construct($config);
        }
    }

/**
 * Activate user
 * @return type
 */
    public function activate() {
        $user = $this->user;
        $user->removeActivateToken();
        $user->status = User::STATUS_ACTIVE;
        return $user->save();
    }

}
