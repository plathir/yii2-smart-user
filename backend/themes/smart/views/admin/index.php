<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use plathir\user\common\helpers\UserHelper;

$userHelper = new UserHelper();

/* @var $this yii\web\View */
/* @var $searchModel common\extensions\user\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-primary">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <div class="user-account-index">

            <p>
                <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Settings'), ['/user/settings'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'header' => 'Image',
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $grid) {
                            $userHelper = new UserHelper();
                            return Html::img($userHelper->getProfileImage($model->id, $this), ['alt' => '...',
                                        'class' => 'img-circle',
                                        'width' => '30',
                                        'align' => 'center']);
                        }
                    ],
                    'id',
                    'username',
                    [
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $grid) {
                            $userHelper = new UserHelper();
                            return Html::decode($userHelper->getProfileFullName($model->id));
                        }
                    ],
                    'email',
                    [
                        'attribute' => 'status',
                        'value' => function($model, $key, $index, $widget) {
                            $userHelper = new UserHelper();
                            return $model->status == true ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                        },
                        'format' => 'html',
                        'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'status', ['0' => 'Inactive', '10' => 'Active'], ['class' => 'form-control', 'prompt' => 'Select...']),
                        'contentOptions' => ['style' => 'width: 10%;']
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 70px;']
                    ],
                ],
            ]);
            ?>

        </div>      
    </div>
</div>


