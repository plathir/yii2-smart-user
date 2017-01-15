<?php

/*
 * Create User Model 
 */

namespace plathir\user\backend\models\admin;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/** * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $activate_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_visited
 * @property string $password write-only password_get_info($hash)

 * */
class CreateUserForm extends ActiveRecord {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public $password;

    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\plathir\user\common\models\account\User', 'message' => 'This username has already been taken.',
                'when' => function ($model, $attribute) {
                    if ($this->oldAttributes) {
                        return $this->oldAttributes[$attribute] != $model->$attribute;
                    } else
                        return true;
                },
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['status', 'required'],
            ['email', 'email'],
            ['last_visited', 'integer'],
            ['email', 'unique', 'targetClass' => '\plathir\user\common\models\account\User',
                'message' => 'This email address has already been taken.',
                'when' => function ($model, $attribute) {
                    if ($this->oldAttributes) {
                        return $this->oldAttributes[$attribute] != $model->$attribute;
                    } else {
                        return true;
                    }
                },
            ],
            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            return true;
        } else {
            return false;
        }
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getStatusText() {
        if ($this->status == self::STATUS_INACTIVE) {
            return 'Inactive';
        }
        if ($this->status == self::STATUS_ACTIVE) {
            return 'Active';
        }
    }

}
