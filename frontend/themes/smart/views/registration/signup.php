<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
?>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="../../index2.html"><b>Admin</b>LTE</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="form-group has-feedback">
                    <?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => "Enter Username"])->label(false); ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>            
                <div class="form-group has-feedback">
                    <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => "Enter Email"])->label(false); ?>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>            

                <div class="form-group has-feedback">
                    <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Enter Password"])->label(false); ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>            
            

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
             <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'signup-button']) ?>
            </div>
                        

                    </div>
                    <!-- /.col -->
                </div>
                <?php ActiveForm::end(); ?>

            <a href="login.html" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.register-box -->
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






