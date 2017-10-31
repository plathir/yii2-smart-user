<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\helpers\Url;

?>

<body class="hold-transition register-page">
    <div class="register-box" style="margin:auto">
        <div class="register-logo">
            <a href="../../index2.html"><b>SmartB</b>yii</a>
        </div>
        <div class="register-box-body">
            <p class="login-box-msg"><?= Yii::t('user','Register a new membership') ?></p>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="form-group has-feedback">
                <?= $form->field($model, 'username')->textInput()->input('username', ['placeholder' => Yii::t('user',"Enter Username")])->label(false); ?>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>            
            <div class="form-group has-feedback">
                <?= $form->field($model, 'email')->textInput()->input('email', ['placeholder' => Yii::t('user',"Enter Email")])->label(false); ?>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>            

            <div class="form-group has-feedback">
                <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => Yii::t('user',"Enter Password")])->label(false); ?>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>            


            <div class="row">
                <div class="col-lg-8">
                    <?= $form->field($model, 'terms', [
                        'template' => "{input}"])
                            ->checkbox(['class' => 'icheck',
                                'label' => Yii::t('user','I agree to the ').'<a href="#">terms</a>',
                                'labelOptions' => ['style' => "padding-left: 0px;"]
                    ]);
                    ?>      
                </div>    
                <div class="col-lg-4">   
                    <div class="form-group has-feedback">
                        <?= Html::submitButton(Yii::t('user','Signup'), ['class' => 'btn btn-primary btn-block btn-flat pull-right', 'name' => 'signup-button']) ?>
                    </div>
                </div>



                <!-- /.col -->
            </div>
            <?php ActiveForm::end(); ?>
            <?= Html::a( Yii::t('user','I already have a membership') ,Url::to(['security/login']), ['class' => 'text-center', 'id' => 'modalButtonProfile']) ?>
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






