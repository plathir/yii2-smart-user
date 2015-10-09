<?php

namespace plathir\user\models\admin;

use yii\behaviors\TimestampBehavior;
use Yii;
use vova07\fileapi\behaviors\UploadBehavior;
use plathir\user\controllers\AdminController;


/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $birth_date
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $updated_by
 */
class AdminUsers extends \yii\db\ActiveRecord {

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
            [['id', 'username', 'email', 'status', 'role'], 'required'],
            [['id', 'status', 'updated_at', 'updated_at'], 'integer'],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
}