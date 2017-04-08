<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use plathir\user\common\userAsset;
use plathir\user\common\helpers\UserHelper;

$userHelper = new UserHelper();

$this->title = Yii::t('app', 'View User');
$this->params['breadcrumbs'] = [
    ['label' => 'Users', 'url' => ['index']],
    $this->title
];

$user_html = DetailView::widget([
            'model' => $account,
            'attributes' => [
                'id',
                'username',
                'email:email',
                [
                    'label' => 'Status',
                    'attribute' => 'status',
                    'value' => $account->getStatusText(),
                ],
                'timezone',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]);

//echo $user_html;

if ($profile) {
    $profile_html = '<br>' .
            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update Profile'), ['update-profile', 'id' => $profile->id], ['class' => 'btn btn-success']) . '&nbsp' .
            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete Profile'), ['delete-profile', 'id' => $profile->id], ['class' => 'btn btn-danger', 'data-method' => 'post',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) .
            '<br><br>' .
            DetailView::widget([
                'model' => $profile,
                'attributes' => [
                    'id',
                    'first_name',
                    'last_name',
                    [
                        'label' => 'Gender',
                        'attribute' => 'gender',
                        'value' => $profile->getGenderLabel(),
                    ],
                    'profile_image',
                    'birth_date',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
    ]);
} else {
//    $profile_html = 'No Profile Data';
    $profile_html = '<br>Profile not update yet ! <br> <br>' .
            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Profile'), ['create-profile', 'id' => $account->id], ['class' => 'btn btn-success']) .
            '<br><br>';
}

$roles_html = '';

if ($roles != null) {
    $roles_html .= '<table class="table table-bordered">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($roles as $role) {
        $roles_html .= '<tr><td>' . $role->name . '</td><td>' . $role->description . '</td></tr>';
    }
    $roles_html .= '</tbody>
    </table>';
}


$items[] = [
    'label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account',
    'encode' => false,
    'content' => '<br>' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update User'), ['update', 'id' => $account->id], ['class' => 'btn btn-success']) . '&nbsp' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete User'), ['delete', 'id' => $account->id], ['class' => 'btn btn-danger', 'data-method' => 'post',
        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) . '&nbsp' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Reset Password'), ['reset-password', 'id' => $account->id], ['class' => 'btn btn-warning']) . '&nbsp' .
    Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Set Password'), ['set-password', 'id' => $account->id], ['class' => 'btn btn-primary']) . '&nbsp' .
    '<br><br>' .
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

$items[] = [
    'label' => '<span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Roles',
    'encode' => false,
    'content' => '<br>' . Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update Roles for user'), ['/admin/assignment/view', 'id' => $account->id], ['class' => 'btn btn-success']) . '&nbsp' . '<br><br>' .
    $roles_html,
    //   'headerOptions' => ['class'=>"col-lg-3"],
    'options' => ['id' => 'rolesTab'],
];
?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="text-center">
            <?php $bundle = userAsset::register($this); ?>

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <?php
                    echo Html::img($userHelper->getProfileImage($account->id, $this), ['alt' => '...',
                        'class' => 'img-circle',
                        'width' => '100',
                        'align' => 'center']);
                    ?>

                </div>
                <div class="panel-body">
                    <p><b><?= '(' . $account->username . ')' ?> 
                            <?= $userHelper->getProfileFullName($account->id) ?></b></p>
                </div>

                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item"><?php echo '<b>Email : </b>' . $account->email; ?></li>
                    <li class="list-group-item"><?php echo '<b>Created : </b>' . Yii::$app->formatter->asDatetime($account->created_at); ?></li>
                    <li class="list-group-item"><?php echo '<b>Updated : </b>' . Yii::$app->formatter->asDatetime($account->updated_at); ?></li>
                    <li class="list-group-item"><?php echo '<b>Last Login : </b>' . Yii::$app->formatter->asDatetime($account->last_visited); ?></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-md-9 col-sm-6 col-xs-12 personal-info">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">        
                <h3>
                    Data for user : <?= $account->username; ?> 
                </h3>
            </div>
            <div class="panel-body">          

                <div>
                    <?php
                    echo Tabs::widget([
                        'items' => $items,
                    ]);
                    ?>
                    <?php //echo yii::getAlias($module->ProfileImagePath); ?>  
                </div>
            </div>
        </div>
    </div>


</div>
