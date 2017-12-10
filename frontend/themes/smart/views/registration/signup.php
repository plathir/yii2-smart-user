<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="container">
    <div class="row">
        <div id="site-singup-area" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">  
            <div class="panel panel-default">
                <div class="panel-heading">Singup</div>
                <div class="panel-body">      
                    <div class="row">
                        <?php $form = ActiveForm::begin(['id' => 'singup-form']); ?>
                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'username', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>{input}</div>'
                            ])->textInput()->input('username', ['placeholder' => Yii::t('user', "Username")])->label(false);
                            ?>

                        </div>
                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'email', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>{input}</div>'
                            ])->textInput()->input('email', ['placeholder' => Yii::t('user', "Enter Email")])->label(false);
                            ?>                        
                        </div>  

                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'password', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}</div>'
                            ])->passwordInput()->input('password', ['placeholder' => Yii::t('user', "Enter Password")])->label(false);
                            ?>
                        </div>

                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'password_repeat', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}</div>'
                            ])->passwordInput()->input('password', ['placeholder' => Yii::t('user', "Repeat Password")])->label(false);
                            ?>
                        </div>


                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'timezone', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-globe" aria-hidden="true"></i></span>{input}</div>'
                            ])->dropDownList($model->timezoneslist); //->input('email', ['placeholder' => Yii::t('user', "Enter Timezone")])->label(false);
                            ?>                        
                        </div>  

                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'terms', ['template' => "{input}"])->checkbox([
                                //'class' => 'icheck',
                                'label' => Yii::t('user', 'I Agree with the '). Html::a(Yii::t('user', 'Terms'), ['/site/terms']),
                                    //  'labelOptions' => ['style' => "padding-left: 0px;"]
                            ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <?= Html::submitButton('<i class="fa fa-pencil-square-o"></i> ' . Yii::t('user', 'Singup'), ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>                
        </div>
    </div>

    <!--
Get Default time zone by client
    -->
    <script type="text/javascript">
        document.getElementById("signupform-timezone").value = Intl.DateTimeFormat().resolvedOptions().timeZone;
    //      document.getElementById("signupform-timezone").value = moment.tz.guess();
    </script>

</div>

