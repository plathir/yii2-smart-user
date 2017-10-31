<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <body class="hold-transition login-page">
        <div class="login-box" style="margin:auto">
            <div class="login-logo">
                <a href="../../index2.html"><b>SmartB</b>yii</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg"><?= Yii::t('user', 'Fill out the following fields to login:') ?></p>
                <div class="row">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <div class="register-box-body">
                        <div class="form-group has-feedback">
                            <?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => Yii::t('user', "Enter Username")])->label(false); ?>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => Yii::t('user', "Enter Password")])->label(false); ?>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-lg-7">
                                <?=
                                $form->field($model, 'rememberMe', ['template' => "{input}"])->checkbox([
                                    'class' => 'icheck',
                                    'label' => Yii::t('user', 'Remember Me'),
                                    'labelOptions' => ['style' => "padding-left: 0px;"]
                                ]);
                                ?>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-5">
                                <div class="form-group has-feedback">
                                    <?= Html::submitButton(Yii::t('user', 'login'), ['class' => 'btn btn-primary btn-block btn-flat pull-right', 'name' => 'login-button']) ?>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <div class="social-auth-links text-center">
                        <?=
                        yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['security/auth'],
                            'popupMode' => true,
                        ])
                        ?>
                    </div>
                    <!-- /.social-auth-links -->
                    <div class="container">
                        <div>
                            <?= Html::a(Yii::t('user', 'I forgot my password'), ['/user/registration/request-password-reset']) ?>
                        </div>

                        <div>
                            <?= Html::a(Yii::t('user', 'Register a new membership'), ['/user/registration/signup']) ?>
                        </div>
                    </div>


                    <?php
                    $js = "$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' 
    });
  });";

                    $this->registerJs(
                            $js, View::POS_READY
                    );
                    ?>

                </div>
            </div>
        </div>
    </body>
</div>
