<?php
namespace plathir\user\models;

use plathir\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AccountForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $new_password;

    public $viewPath = '@vendor/plathir/yii2-smart-user/views/mail';
        
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'exist', 'targetClass' => '\plathir\user\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\plathir\user\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function edit()
    {
            $user = new User();
            $user->findIdentity(\Yii::$app->user->identity->id);
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            //print_r($user);
            
            if ($user->save()) {
                return true;
            }


        return null;
    }
    

    
}
