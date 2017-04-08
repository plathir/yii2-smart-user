<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use plathir\cropper\Widget as NewWidget;
use yii\helpers\Url;
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
        <?php $form = ActiveForm::begin(['id' => 'form-update', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <?php
        echo $profile->profile_image . '<br>';
        //echo $form->field($profile, 'profile_image');
        echo $form->field($profile, 'profile_image')->widget(NewWidget::className(), [
            'uploadUrl' => Url::toRoute(['/user/user-profile/uploadphoto']),
            'previewUrl' => $profile->module->ProfileImagePathPreview,
            'tempPreviewUrl' => $profile->module->ProfileImageTempPathPreview,
            //   'KeyFolder' => $profile->id,
            'width' => 200,
            'height' => 200,
        ]);
        ?>

        <?= $form->field($profile, 'first_name') ?>
        <?= $form->field($profile, 'last_name') ?>
        <?= $form->field($profile, 'gender')->dropDownList(['1' => 'Male', '2' => 'Female']); ?>
        <?=
        $form->field($profile, 'birth_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter birth date ...'],
            'pluginOptions' => [
                //  'language' => 'el',
                'autoclose' => true,
                'format' => 'yyyy/mm/dd'
            ]
        ]);
        ?>
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

