<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
?>


<div class="container">
    <div class="row">
        <div id="site-request-password-reset-area" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">  
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('user','Request Password Reset') ?></div>
                <div class="panel-body">                    
                    <div class="row">
                        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'email', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>{input}</div>'
                            ])->textInput()->input('email', ['placeholder' => Yii::t('user', "Enter Email")])->label(false);
                            ?> 
                        </div>                            

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <?= Html::submitButton('<i class="fa fa-envelope-o"></i> '.Yii::t('user', 'Send'), ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>    
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>
