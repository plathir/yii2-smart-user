<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="container">
    <div class="row">
        <div id="reset_pwd-area" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">  
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('user','Reset Password') ?></div>
                <div class="panel-body">      
                    <div class="row">
                        <?php $form = ActiveForm::begin(['id' => 'reset_pwd-form']); ?>
                        <div class="col-sm-12">
                            <?=
                            $form->field($model, 'password', [
                                'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}</div>'
                            ])->passwordInput()->input('password', ['placeholder' => Yii::t('user', "Enter Password")])->label(false);
                            ?>
                        </div>

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success btn-block', 'name' => 'save-button']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>