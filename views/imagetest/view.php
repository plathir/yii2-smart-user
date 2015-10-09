<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

if ($profile) {
    $profile_html = '<br>' .
            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update Profile'), ['update', 'id' => $profile->id], ['class' => 'btn btn-success']) . '&nbsp' .
            '<br><br>' .
            DetailView::widget([
                'model' => $profile,
                'attributes' => [
                    'id',
                    'first_name',
                    'last_name',
                    'gender',
                    'profile_image',
                    'birth_date',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
    ]);
    
    echo $profile_html;
}