<?php

namespace plathir\user\common\models\account;

//use plathir\user\models\common\account\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AccountForm extends Model {
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    
    public $username;
    public $email;
    public $new_password;
    public $password;
    public $timezone;
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
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['timezone', 'string'],
            ['username', 'unique',
                'targetClass' => '\plathir\user\common\models\account\User',
                'message' => 'This username already been taken.',
                'when' => function ($model, $attribute) {
                    return $this->user->$attribute != $model->$attribute;
                },
            ],
            [ 'email', 'unique',
                'targetClass' => '\plathir\user\common\models\account\User',
                'message' => 'This email already been taken.',
                'when' => function ($model, $attribute) {
                    return $this->user->$attribute != $model->$attribute;
                },
            ],
            ['timezone', 'string'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'User Name'),
            'email' => Yii::t('user', 'E-Mail'),
            'status' => Yii::t('user', 'Status'),
            'role' => Yii::t('user', 'User Role'),
            'timezone' => Yii::t('user', 'Time Zone'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
            'full_name' => Yii::t('user', 'Full Name'),
        ];
    }    
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function ValidateAndSave() {

        if ($this->validate()) {
            $upd_user = \Yii::$app->user->identity;
            $upd_user->username = $this->username;
            $upd_user->email = $this->email;
            $upd_user->timezone = $this->timezone;
            $upd_user->generateAuthKey();
            if ($upd_user->update()) {
                return true;
            }
        } 
        return null;
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

