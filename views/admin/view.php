<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;

$this->title = Yii::t('app', 'View User');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php

$user_html = DetailView::widget([
            'model' => $account,
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

//echo $user_html;

if ($profile) {
    $profile_html = '<br>'.
            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update Profile'), ['update-profile', 'id' => $profile->id], ['class' => 'btn btn-success']) . '&nbsp' .
            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete Profile'), ['delete-profile', 'id' => $profile->id], ['class' => 'btn btn-danger', 'data-method' => 'post',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) . 
                  '<br><br>'.

            DetailView::widget([
                'model' => $profile,
                'attributes' => [
                    'id',
                    'first_name',
                    'last_name',
                    'gender',
                    'birth_date:date',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
    ]);
} else {
//    $profile_html = 'No Profile Data';
            $profile_html = 'Profile not update yet ! <br> <br>' .
                Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Profile'), ['create-profile', 'id'=> $account->id], ['class' => 'btn btn-success']) .    
                '<br><br>';
}




$items[] = [
    'label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account',
    'encode' => false,
    'content' => '<br>' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update User'), ['update', 'id' => $account->id], ['class' => 'btn btn-success']) .'&nbsp' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete User'), ['delete', 'id' => $account->id], ['class' => 'btn btn-danger', 'data-method' => 'post',
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) .'&nbsp' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Reset Password'), ['reset-password', 'id' => $account->id], ['class' => 'btn btn-warning']) .'&nbsp' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Set Password'), ['set-password', 'id' => $account->id], ['class' => 'btn btn-primary']) .'&nbsp' .
    '<br><br>'.
    $user_html,
    'options' => ['id' => 'AccountTab'],
];

$items[] = [
    'label' => '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Profile',
    'encode' => false,
    'content' =>
    $profile_html,
//        'content' =>  $this->renderAjax('update', [
//                            'model' => $model,
//                ]),
    'options' => ['id' => 'ProfileTab'],
];


echo Tabs::widget([
    'items' => $items,
]);

