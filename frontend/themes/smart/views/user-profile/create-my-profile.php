<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\extensions\user\models\UserProfile */

$this->title = Yii::t('user', 'Create User Profile');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Profiles'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-create">

    <?= $this->render('_form_create', [
        'model' => $model,
    ]) ?>

</div>
