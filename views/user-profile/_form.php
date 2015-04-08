<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\extensions\user\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 40]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 40]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'birth_date')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
