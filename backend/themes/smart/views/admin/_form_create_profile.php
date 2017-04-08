    <?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
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
//        echo $form->field($profile, 'profile_image')->widget(FileAPI::className(), [
//            'settings' => [
//                'url' => ['user-profile/fileapi-upload'],
//                'autoUpload' => true,
//            ],
//            'crop' => true,
//            'cropResizeWidth' => 200,
//            'cropResizeHeight' => 200
//        ]);
        ?>
        
        <?= $form->field($profile, 'first_name') ?>
        <?= $form->field($profile, 'last_name') ?>
        <?= $form->field($profile, 'gender')->dropDownList(['1' => 'Male', '2' => 'Female']); ?>
        <?=
        $form->field($profile, 'birth_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter birth date ...'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy/mm/dd'
            ]
        ]);
        ?>        
        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

