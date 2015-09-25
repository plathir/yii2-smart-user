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
                <?= $form->field($account, 'status') ?>
                <?= $form->field($account, 'role') ?>
                <?= $form->field($account, 'password')->passwordInput(); ?>
                <div class="form-group">
                    <?= Html::submitButton('Create' , ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    