<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use vova07\fileapi\Widget as FileAPI;
use plathir\cropper\Widget as NewWidget;

/* @var $this yii\web\View */
/* @var $model common\extensions\user\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-profile-form">


    <?php $form = ActiveForm::begin(['options' => ['id' => 'profile-form', 'enableAjaxValidation' => true]]); ?>  
    <?php
//    echo $form->field($model, 'profile_image')->widget(FileAPI::className(), [
//        'settings' => [
//            'url' => ['admin/fileapi-upload'],
//            'autoUpload' => true,
//        ],
//        'crop' => true,
//        'cropResizeWidth' => 200,
//        'cropResizeHeight' => 200
//    ]);

    echo $form->field($model, 'profile_image')->widget(NewWidget::className(), [
        'uploadUrl' => Url::toRoute(['/user/user-profile/uploadphoto']),
        'previewUrl' => $model->module->ImagePathPreview,
        'tempPreviewUrl' => $model->module->ImageTempPathPreview,
        'width' => 200,
        'height' => 200,
    ]);
    ?>

    <?= $form->field($model, 'id')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 40]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 40]) ?>

    <?= $form->field($model, 'gender')->dropDownList(['1' => 'Male', '2' => 'Female']); ?>

    <?=
    $form->field($model, 'birth_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter birth date ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy/mm/dd'
        ]
    ]);
    ?>

    <?php //= $form->field($model, 'updated_at')->textInput()  ?>

    <?php //= $form->field($model, 'updated_by')->textInput()  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>