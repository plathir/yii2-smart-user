<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = Yii::t('user', 'Edit My Account');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div id="site-login-area" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('user', 'Please fill out the following fields to change my User Data:') ?>
        </div><!-- /.box-header -->
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['options' => ['id' => $model->formName(), 'enableAjaxValidation' => true, 'enableClientValidation' => true],]); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'timezone')->dropDownList($model->timezoneslist) ?>            
            <?= ''; //$form->field($model, 'timezone')->dropDownList($model->timezoneslist) ?>            
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('user', 'Save'), ['class' => 'btn btn-success btn-flat btn-loader', 'name' => 'update-button', 'id' => 'accountSubmit']) ?>
                <?= \yii\helpers\Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i> ' . Yii::t('user', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-primary pull-right btn-loader']); ?>
            </div>
            <?php ActiveForm::end(); ?>        
        </div>
    </div>
</div>

    <!--
Get Default time zone by client
    -->
    <script type="text/javascript">
    //   if (document.load().getElementById("accountform-timezone").value == null) {
             document.getElementById("accountform-timezone").value =  Intl.DateTimeFormat().resolvedOptions().timeZone;            
    //    }
    //     document.getElementById("signupform-timezone").value = moment.tz.guess();
    </script>