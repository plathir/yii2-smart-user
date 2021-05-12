<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use plathir\cropper\Widget as NewWidget;
use yii\helpers\Url;
use \backend\widgets\SmartDate;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div><!-- /.box-header -->
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'form-update', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                echo $form->field($model, 'profile_image')->widget(NewWidget::className(), [
                    'uploadUrl' => Url::toRoute(['/user/user-profile/uploadphoto']),
                    'previewUrl' => $model->module->ProfileImagePathPreview,
                    'tempPreviewUrl' => $model->module->ProfileImageTempPathPreview,
                    //   'KeyFolder' => $model->id,
                    'width' => 200,
                    'height' => 200,
                ]);
                ?>             
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'first_name') ?>
                <?= $form->field($model, 'last_name') ?>
                <?= $form->field($model, 'gender')->dropDownList(['1' => Yii::t('user', 'Male'), '2' => Yii::t('user', 'Female')]); ?>
                <?= $form->field($model, 'birth_date')->widget(SmartDate::classname(), ['type' => 'inputDate', 'model' => $model, 'attribute' => 'birth_date']); ?>                
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('user', 'Create'), ['class' => 'btn btn-success btn-flat btn-loader']) ?>
            <?= \yii\helpers\Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> ' . Yii::t('user', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-primary pull-right btn-loader']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>