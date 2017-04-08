<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<p>Please fill out the following fields to update:</p>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id' => 'form-update']); ?>
        <?= $form->field($account, 'username') ?>
        <?= $form->field($account, 'email') ?>
        <?= $form->field($account, 'timezone')->dropDownList($account->timezoneslist) ?>   
        <?= $form->field($account, 'status')->dropDownList(['10' => 'Active', '0' => 'Inactive']); ?>
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
