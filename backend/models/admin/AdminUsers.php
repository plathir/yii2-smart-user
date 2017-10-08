<?php

namespace plathir\user\backend\models\admin;

use yii\behaviors\TimestampBehavior;
use Yii;
use \plathir\user\common\models\profile\UserProfile;


/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $birth_date
 * @property string $timezone
 * @property integer $updated_at
 * @property integer $created_at
 */
class AdminUsers extends \yii\db\ActiveRecord {
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
  
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'username', 'email', 'status' ], 'required'],
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['first_name'], 'string'],
            [['full_name'], 'string'],
            [['timezone' ], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'User Name'),
            'email' => Yii::t('app', 'E-Mail'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'User Role'),
            'timezone' => Yii::t('app', 'User Role'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'full_name' => Yii::t('app', 'Full Name'),
        ];
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
    
        public function getUser_profile() {
        return $this->hasOne(UserProfile::className(), ['id' => 'id']);
    }
       public function getRoles() {
         return  \Yii::$app->authManager->getRolesByUser($this->id);

         }
}
