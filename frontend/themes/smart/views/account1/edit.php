<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Edit Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to edit account:</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['options' => ['id' => $model->formName(), 'enableAjaxValidation' => true, 'enableClientValidation' => true],]); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button', 'id' => 'accountSubmit']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS

$('form#{$model->formName()}').on('beforeSubmit', function(e) {
 
  var \$form = $(this);
//post ajax url
   $.post(\$form.attr("action"), \$form.serialize())
      .done(function(result) 
          { 
           
             $('#modalAccount').modal('hide');
         })
      .fail(function(result)
           {
             
            console.log(result)
           });

     return false;
   });   
        
JS;


//echo '<pre>';
//print_r($script);
//echo '</pre>';
$this->registerjs($script);
?>


