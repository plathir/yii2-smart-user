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
 * @property integer $gender
 * @property string $birth_date
 * @property integer $updated_at
 * @property integer $updated_by

 * */
class CreateProfileForm extends ActiveRecord {

    public $password;

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
            [['first_name', 'last_name'], 'string', 'max' => 40]
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
