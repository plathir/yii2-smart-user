<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use yii\helpers\Html;

$this->title = Yii::t('app', 'Update User');
$this->params['breadcrumbs'][] = $this->title;    

?>

<div class="user-account-update">
    <h1><?= Html::encode($this->title) ?></h1>

    	<?php echo $this->render('_form_update', [
		'account' => $account,
	]); ?>
    
</div>
    