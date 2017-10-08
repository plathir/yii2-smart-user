<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<?php
//$items = DateTimeZone::listIdentifiers();
//$newItems = [];
//$key_h = 0;
//
//foreach ($items as $key => $value) {
//    $key_h = $key_h + 1;
//    $newItems[$key_h]['id'] = $key_h;
//    $newItems[$key_h]['timezone'] = $value;
//};
//$timezonesList = \yii\helpers\ArrayHelper::map($newItems, 'timezone', 'timezone');
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= 'Please fill out the following fields to create User:' ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id' => 'form-create']); ?>
        <?= $form->field($account, 'username') ?>
        <?= $form->field($account, 'email') ?>
        <?= $form->field($account, 'status')->dropDownList(['10' => 'Active', '0' => 'Inactive']); ?>
        <?= $form->field($account, 'timezone')->dropDownList($account->timezoneslist) ?>            
        <?= $form->field($account, 'password')->passwordInput(); ?>
        <div class="form-group">
                        <?=
            Html::submitButton(Html::tag('span', '<i class="fa fa-save"></i>' . '&nbsp' . Yii::t('user', 'Create'), [
                        'title' => Yii::t('user', 'Create Record'),
                        'data-toggle' => 'tooltip',
                    ]), ['class' => 'btn btn-primary btn-flat btn-loader'])
            ?>
            <?= ''; // Html::submitButton('<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Create', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>        
    </div>
</div>

<!--
Get Default time zone by client
-->
<script type="text/javascript">
    document.getElementById("createuserform-timezone").value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
