<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('user','Change Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-password">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('user', 'Please fill out the following fields to Change Password:') ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
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
                <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-primary btn-flat btn-loader', 'name' => 'update-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

