<?php

namespace plathir\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $birth_date
 * @property integer $updated_at
 * @property integer $updated_by
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'first_name', 'last_name', 'gender', 'birth_date', 'updated_at', 'updated_by'], 'required'],
            [['id', 'gender', 'updated_at', 'updated_by'], 'integer'],
            [['birth_date'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
