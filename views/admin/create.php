<?php

/* 
 *  Create User ( Admin )
 * 
 *  
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = $this->title;    

?>

<div class="user-account-index">
    <h1><?= Html::encode($this->title) ?></h1>

    	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>
    
</div>
    
    