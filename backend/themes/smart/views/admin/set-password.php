<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Set Password for user : ' . $model->id. '-'. $model->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <p>Please fill out the following fields to set Password:</p>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin(['id' => 'form-set-password']); ?>
            <?= $form->field($model, 'new_password')->passwordInput() ?>            
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>