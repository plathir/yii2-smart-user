<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


    <p>Please fill out the following fields to Create:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-create']); ?>
                <?= $form->field($account, 'username') ?>
                <?= $form->field($account, 'email') ?>
                <?= $form->field($account, 'status')->dropDownList(['10' => 'Active', '0' => 'Inactive']); ?>
                <?= $form->field($account, 'timezone') ?>            
                <?= $form->field($account, 'password')->passwordInput(); ?>
                <div class="form-group">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Create' , ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    