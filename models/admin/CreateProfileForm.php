<?php

/*
 * Create User Model 
 */

namespace plathir\user\models\admin;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/** * @property integer $id
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $profile_image
 * @property integer $gender
 * @property file $file
 * @property string $birth_date
 * @property integer $updated_at
 * @property integer $updated_by

 * */
class CreateProfileForm extends ActiveRecord {

    public $file;

    public static function tableName() {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['first_name', 'last_name', 'gender', 'birth_date'], 'required'],
            [['gender', 'updated_at', 'updated_at', 'updated_by'], 'integer'],
            [['birth_date'], 'safe'],
            [['file'], 'file'],
            [['profile_image'], 'string', 'max' => 200],
            [['first_name', 'last_name'], 'string', 'max' => 40]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'file' => Yii::t('app', 'File for Profile Image'),
            'profile_image' => Yii::t('app', 'Profile Image'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            $this->updated_by = \Yii::$app->user->identity->id;
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
