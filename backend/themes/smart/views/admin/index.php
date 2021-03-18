<?php

use yii\helpers\Html;
use yii\grid\GridView;
use plathir\user\common\helpers\UserHelper;
use \backend\widgets\SmartDate;

$userHelper = new UserHelper();

/* @var $this yii\web\View */
/* @var $searchModel common\extensions\user\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'User Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">        
        <div class="user-account-index">
            <p>

                <?=
                Html::a(Html::tag('span', '<i class="fa fa-fw fa-plus"></i>' . '&nbsp' . Yii::t('user', 'Create'), [
                            'title' => Yii::t('user', 'Create New User'),
                            'data-toggle' => 'tooltip',
                        ]), ['create'], ['class' => 'btn btn-success btn-flat btn-loader'])
                ?>                
            </p>

            <?php ?>
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
                        },
                        'filterOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'headerOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'contentOptions' => ['data-columnname' => 'Image', 'class' => 'hidden-xs hidden-sm hidden-md'],
                    ],
                    'id',
                    ['attribute' => 'username',
                        'value' => function ($model) {
                            $username_html = $model->username . '<br>';
                            foreach ($model->roles as $role) {
                                $username_html .= '<span class="label label-info">' . $role->name . '</span>&nbsp';
                            }
                            return $username_html;
                        },
                        'format' => 'raw'
                    ],
                    ['attribute' => 'full_name',
                        //  'label' => 'full_name',
                        'value' => function($model) {
                            return $model->user_profile['first_name'] . ' ' . $model->user_profile['last_name'];
                        },
                        'filterOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'headerOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'contentOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                    ],
                    'email',
                    [
                        'attribute' => 'status',
                        'value' => function($model, $key, $index, $widget) {
                            
                            return $model->Activebadge;
                        },
                        'format' => 'html',
                        'filter' => Html::activeDropDownList($searchModel, 'status', ['0' => Yii::t('user','Inactive'), '10' => Yii::t('user','Active')], ['class' => 'form-control', 'prompt' => 'Select...']),
                        'contentOptions' => ['style' => 'width: 10%;']
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:' . Yii::$app->settings->getSettings('ShortDateFormat')],
                        'value' => 'created_at',
                        'filter' => SmartDate::widget(['type' => 'filterShortDate', 'model' => $searchModel, 'attribute' => 'created_at']),
                        'contentOptions' => ['style' => 'width: 12%;']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:' . Yii::$app->settings->getSettings('ShortDateFormat')],
                        'value' => 'updated_at',
                        'filter' => SmartDate::widget(['type' => 'filterShortDate', 'model' => $searchModel, 'attribute' => 'updated_at']),
                        'filterOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'headerOptions' => ['class' => 'hidden-xs hidden-sm hidden-md'],
                        'contentOptions' => ['data-columnname' => 'Upadted_at', 'style' => 'width: 12%;', 'class' => 'hidden-xs hidden-sm hidden-md'],
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 70px;']
                    ],
                ],
            ]);
            ?>

        </div>      
    </div>
</div>


