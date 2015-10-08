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

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-update', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <?php if ($profile->profile_image != '') { ?>
            <img src=<?php echo yii::getAlias($module->ProfileImagePath) . '/' . $profile->profile_image; ?> alt="..." class="img-circle" width="150" align="center" > 
            <?php echo '<br>' . Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete Image'), ['delete-image', 'id' => $profile->id], ['class' => 'btn btn-danger']) . '&nbsp' ?>
            <?php
        } else {
            echo $form->field($profile, 'file')->fileInput();
        }
        ?>

        <?= $form->field($profile, 'first_name') ?>
        <?= $form->field($profile, 'last_name') ?>
        <?= $form->field($profile, 'gender') ?>


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

