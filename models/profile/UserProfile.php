<?php

namespace plathir\user\models\profile;

use plathir\cropper\behaviors\UploadImageBehavior;
use yii\behaviors\TimestampBehavior;
use Yii;
use vova07\fileapi\behaviors\UploadBehavior;
use plathir\user\traits\ModuleTrait;
use plathir\user\models\account\User;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $birth_date
 * @property string $profile_image
 * @property integer $updated_at
 * @property integer $updated_by
 */
class UserProfile extends \yii\db\ActiveRecord {

    use ModuleTrait;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'first_name', 'last_name', 'gender', 'birth_date'], 'required'],
            [['id', 'gender', 'updated_at', 'updated_at', 'updated_by'], 'integer'],
            [['birth_date'], 'safe'],
            [['profile_image'], 'string', 'max' => 200],
            [['first_name', 'last_name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
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
//            'uploadBehavior' => [
//                'class' => UploadBehavior::className(),
//                'attributes' => [
//                    'profile_image' => [
//                        'path' => $this->module->ProfileImagePath,
//                        'tempPath' => $this->module->ProfileImageTempPath,
//                        'url' => $this->module->ProfileImagePathPreview
//                    ]
//                ]
//            ],
            'uploadImageBehavior' => [
                'class' => UploadImageBehavior::className(),
                'attributes' => [
                    'profile_image' => [
                        'path' => $this->module->ProfileImagePath,
                        'temp_path' => $this->module->ProfileImageTempPath,
                        'url' => $this->module->ProfileImagePathPreview,
                      //  'key_folder' => 'id'
                    ],
                ]
            ]
        ];
    }

    public function getGenderLabel() {
        return $this->gender == 1 ? 'Male' : 'Female';
    }

    public function getUpadatedByUserName() {
        $account = User::find()
                ->where(['id' => $this->id])
                ->one();
        if ($account) {
            return $account->username;
        }
    }

}
