<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>SmartB</b>yii
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"><?= Yii::t('user', 'Sign in to Admin Area') ?></p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>              
            <div class="form-group has-feedback">
                <?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => Yii::t('user', "Enter Username")])->label(false); ?>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>             
            <div class="form-group has-feedback">
                <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => Yii::t('user', "Enter Password")])->label(false); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div> 
            <div class="row">
                <div class="col-xs-8">
                    <?=
                    $form->field($model, 'rememberMe', ['template' => "{input}"])->checkbox([
                        'class' => 'icheck',
                        'label' => Yii::t('user', 'Remember Me'),
                        'labelOptions' => ['style' => "padding-left: 0px;"]
                    ]);
                    ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= Html::submitButton(Yii::t('user', 'login'), ['class' => 'btn btn-primary btn-block btn-flat pull-right', 'name' => 'login-button']) ?>
                </div>
                <!-- /.col -->
            </div>
            <?php ActiveForm::end(); ?>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <?php
    $js = "$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' ,
    });
  });";

    $this->registerJs(
            $js, View::POS_READY
    );
    ?>
</body>
