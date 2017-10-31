<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('user', 'Edit My Account');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('user', 'Please fill out the following fields to edit my User Data:') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php $form = ActiveForm::begin(['options' => ['id' => $model->formName(), 'enableAjaxValidation' => true, 'enableClientValidation' => true],]); ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'timezone')->dropDownList($model->timezoneslist) ?>            
        <?= ''; //$form->field($model, 'timezone')->dropDownList($model->timezoneslist) ?>            
        <div class="form-group">
            <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-primary btn-flat btn-loader', 'name' => 'update-button', 'id' => 'accountSubmit']) ?>
        </div>
        <?php ActiveForm::end(); ?>        
    </div>
</div>