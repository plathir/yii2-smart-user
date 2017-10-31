<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\extensions\user\models\UserProfile */

$this->title = Yii::t('user', 'Update my Profile')
?>
<div class="my-profile-edit">
    <?= $this->render('_form_edit', [
        'model' => $model,
    ]) ?>

</div>
