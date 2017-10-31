<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('user', 'Please fill out the following fields to update user : ') . $account->username; ?></h3>
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
        <?= $form->field($account, 'status')->dropDownList(['10' => Yii::t('user', 'Active'), '0' => Yii::t('user', 'Inactive')]); ?>
        <div class="form-group">
            <?=
            Html::submitButton(Html::tag('span', '<i class="fa fa-save"></i>' . '&nbsp' . Yii::t('user', 'Update'), [
                        'title' => Yii::t('user', 'Upadte Record'),
                        'data-toggle' => 'tooltip',
                    ]), ['class' => 'btn btn-primary btn-flat btn-loader'])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
