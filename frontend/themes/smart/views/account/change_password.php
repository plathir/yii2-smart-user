<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('user', 'Change Password');
?>
<div id="site-login-area" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('user', 'Please fill out the following fields to Change Password:') ?>
        </div><!-- /.box-header -->
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <div class="col-lg-5 col-md-5 col-sm-12" style="padding: 0px">
                <?= $form->field($model, 'username')->textInput(['readonly' => true]) ?>
            </div>    
            <div class="col-lg-2 col-md-2 col-sm-12" style="padding: 0px">

            </div>
            <div class="col-lg-5 col-md-5 col-sm-12" style="padding: 0px">
                <?= $form->field($model, 'email')->textInput(['readonly' => true]) ?>
            </div>    

            <?= $form->field($model, 'password')->passwordInput() ?>            
            <?= $form->field($model, 'new_password')->passwordInput() ?>            
            <?= $form->field($model, 'new_password_repeat')->passwordInput() ?>            

            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('user', 'Save'), ['class' => 'btn btn-success btn-flat btn-loader', 'name' => 'update-button']) ?>
                <?= \yii\helpers\Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> Back', Yii::$app->request->referrer, ['class' => 'btn btn-primary pull-right btn-loader']); ?>                
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

