<?php
namespace plathir\user\models\security;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $source
 * @property integer $source_id
 */
class Auth extends \yii\db\ActiveRecord {
   
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%auth}}';
    }
    
}