<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\extensions\user\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'header' => 'Image',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) {
                    return Html::img(\plathir\user\helpers\UserHelper::getProfileImage($model->id, $this), ['alt' => '...',
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
                            return Html::decode(\plathir\user\helpers\UserHelper::getProfileFullName($model->id));
                        }
                    ],
                    'email',
                    [
                        'attribute' => 'status',
                        'value' => function($model, $key, $index, $grid) {
                            return $model->getStatusText();
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>



</div>
