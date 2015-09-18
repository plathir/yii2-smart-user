<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;
use yii\helpers\Html;

$this->title = Yii::t('app', 'View User');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::a(Yii::t('app', 'Update User'), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

<?= Html::a(Yii::t('app', 'Delete User'), ['delete', 'id' => $model->id],
                 ['class' => 'btn btn-danger', 'data-method' => 'post', 
                  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?') ]) ?>


<?php

$user_html = DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'email:email',
                'role',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]);

echo $user_html;

