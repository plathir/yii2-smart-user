<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
?>

<body>
    <h3><b>Login</b></h3>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>    
    <div class="register-box-body">
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => "Enter Username"])->label(false); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>             
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Enter Password"])->label(false); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div> 
        <div class="row">
            <div class="col-lg-7">
                <?=
                $form->field($model, 'rememberMe', [
                    'template' => "{input}"])->checkbox(['class' => 'label checkbox icheck pull-left'])->label('Remember Me');
                ?>      
            </div>    
            <!-- /.col -->
            <div class="col-xs-5">
                <div class="form-group has-feedback">
                    <?= Html::submitButton('login', ['class' => 'btn btn-primary btn-block btn-flat pull-right', 'name' => 'login-button']) ?>
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
        <div class="row">
            <?= Html::a('I forgot my password', ['/user/registration/request-password-reset']) ?>
        </div>

        <div class="row">
            <?= Html::a('Register a new membership', ['/user/registration/signup']) ?>
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

</body>