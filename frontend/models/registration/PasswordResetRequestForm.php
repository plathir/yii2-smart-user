<?php

namespace plathir\user\frontend\models\registration;

use plathir\user\common\models\account\User;
use yii\base\Model;
use Yii;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;
    public $viewPath = '@vendor/plathir/yii2-smart-user/common/views/mail';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\plathir\user\common\models\account\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Yii::t('user', 'There is no user with such email.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }
            if ($user->save()) {
                $mailer = \Yii::$app->mailer;
                if (!Yii::$app->settings->getSettings('ResetPasswordTemplate')) {
                    $mailer->viewPath = $this->viewPath;
                    $mailer->getView()->theme = \Yii::$app->view->theme;
                    return $mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                                    ->setTo($this->email)
                                    ->setSubject(Yii::t('user', 'Password reset for ') . \Yii::$app->name)
                                    ->send();
                } else {
                    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/registration/reset-password', 'token' => $user->password_reset_token]);
                    return $mailer->compose()
                                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                                    ->setTo($this->email)
                                    ->setSubject(Yii::t('user', 'Password reset for ') . \Yii::$app->name)
                                    ->setHtmlBody(Yii::$app->templates->getTemplate(Yii::$app->settings->getSettings('ResetPasswordTemplate'), [
                                                '{user}' => $user->username,
                                                '{reset_link}' => $resetLink,
                                                    ]
                                            )
                                    )
                                    ->send();
                }
            }
        }

        return false;
    }

}
