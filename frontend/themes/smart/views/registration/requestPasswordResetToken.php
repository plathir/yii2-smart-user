<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
?>

<div class="site-request-password-reset">

    <body class="hold-transition register-page">
        <div class="register-box" style="margin:auto">
            <div class="register-logo">
                <a href="../../index2.html"><b>SmartB</b>yii</a>
            </div>
            <div class="register-box-body">
                <p class="login-box-msg"><?= Yii::t('user', 'Please fill out your email. A link to reset password will be sent there') ?></p>

                <div class="row">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                    <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => Yii::t('user', "Enter Email")])->label(false); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary btn-flat pull-right']) ?>
                    </div>

                </div>
                <?php ActiveForm::end(); ?>            
            </div>
        </div>
    </body>
</div>






