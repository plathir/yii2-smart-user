<?php

namespace plathir\user\backend\models\admin;

use yii\behaviors\TimestampBehavior;
use Yii;
use \plathir\user\common\models\profile\UserProfile;
use \plathir\user\common\models\account\User;

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
class AdminUsers extends User {

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
            [['id', 'username', 'email', 'status'], 'required'],
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['first_name'], 'string'],
            [['full_name'], 'string'],
            [['timezone'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
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
            return Yii::t('user', 'Inactive');
        }
        if ($this->status == self::STATUS_ACTIVE) {
            return Yii::t('user', 'Active');
        }
    }

    public function getUser_profile() {
        return $this->hasOne(UserProfile::className(), ['id' => 'id']);
    }

    public function getRoles() {
        return \Yii::$app->authManager->getRolesByUser($this->id);
    }

    public function getActivebadge() {
        $badge = '';
        switch ($this->status) {
            case 0:
                $badge = '<span class="label label-danger">' . Yii::t('user', 'Inactive') . '</span>';
                break;
            case 10:
                $badge = '<span class="label label-success">' . Yii::t('user', 'Active') . '</span>';
                break;
            default:
                break;
        }

        return $badge;
    }

}
