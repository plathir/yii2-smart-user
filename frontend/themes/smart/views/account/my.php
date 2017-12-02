<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;
use yii\helpers\Html;
use plathir\user\common\helpers\UserHelper;

$userHelper = new UserHelper();

$this->title = Yii::t('user', 'My Account Profile');

$user_html = DetailView::widget([
            'model' => $account,
            'options' => [
                'class' => 'table table-striped',
            ],
            'attributes' => [
                'id',
                'username',
                'email:email',
                [
                    'label' => 'Status',
                    'attribute' => 'status',
                    'value' => $account->Activebadge,
                    'format' => 'html',
                ],
                'timezone',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]);

if ($profile) {
    $edit_button = Html::a(Html::tag('span', '<i class="fa fa-pencil-square-o"></i>' . '&nbsp' . Yii::t('user', 'Update'), [
                        'title' => Yii::t('user', 'Update User Profile'),
                        'data-toggle' => 'tooltip',
                    ]), ['user-profile/edit-my-profile'], ['class' => 'btn btn-success btn-flat btn-loader btn-flat btn-loader']);


    $delete_button = Html::a(Html::tag('span', '<i class="fa fa-trash-o"></i>' . '&nbsp' . Yii::t('user', 'Delete'), [
                        'title' => Yii::t('user', 'Delete User Profile'),
                        'data-toggle' => 'tooltip',
                    ]), ['user-profile/delete-my-profile'], ['class' => 'btn btn-danger btn-flat btn-loader',
                'data-method' => 'post',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')
    ]);

    $profile_html = $edit_button . '&nbsp' . $delete_button .
            '<br><br>' .
            DetailView::widget([
                'model' => $profile,
                'options' => [
                    'class' => 'table table-striped',
                ],
                'attributes' => [
                    'first_name',
                    'last_name',
                    [
                        'label' => 'Gender',
                        'attribute' => 'gender',
                        'value' => $profile->getGenderLabel(),
                    ],
                    'profile_image',
                    ['attribute' => 'birth_date',
                        'format' => ['date', 'php:d-m-Y'],
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
    ]);
} else {
//    $profile_html = 'No Profile Data';
    $edit_button = Html::a(Html::tag('span', '<i class="fa fa-pencil-square-o"></i>' . '&nbsp' . Yii::t('user', 'Update'), [
                        'title' => Yii::t('user', 'Update User Profile'),
                        'data-toggle' => 'tooltip',
                    ]), ['user-profile/create-my-profile'], ['class' => 'btn btn-success btn-flat btn-loader btn-flat btn-loader']);

    $profile_html = '<br>' . Yii::t('user', 'Profile not update yet !') . ' <br> <br>' .
            $edit_button .
            '<br><br>';
}

$roles_html = '';

if ($roles != null) {
    $roles_html .= '<table class="table table-striped">
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($roles as $role) {
        $roles_html .= '<tr><td>' . '<span class="label label-info">' . $role->name . '</span>' . '</td><td>' . $role->description . '</td></tr>';
    }
    $roles_html .= '</tbody>
    </table>';
}
$acc_button_edit = Html::a(Html::tag('span', '<i class="fa fa-pencil-square-o"></i>' . '&nbsp' . Yii::t('user', 'Update'), [
                    'title' => Yii::t('user', 'Update Account'),
                    'data-toggle' => 'tooltip',
                ]), ['edit'], ['class' => 'btn btn-success btn-flat btn-loader btn-flat btn-loader']);


$acc_button_ch_pass = Html::a(Html::tag('span', '<i class="fa fa-lock"></i>' . '&nbsp' . Yii::t('user', 'Change Password'), [
                    'title' => Yii::t('user', 'Change User Password'),
                    'data-toggle' => 'tooltip',
                ]), ['change-password'], ['class' => 'btn btn-warning btn-flat btn-loader',
        ]);

$user_html = $acc_button_edit . '&nbsp' . $acc_button_ch_pass . // . '&nbsp' . $acc_button_pwd_reset . '&nbsp' . $acc_button_pwd_set . '&nbsp' .
        '<br><br>' .
        $user_html;
?>

<div class="profile-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-default user-profile-box">
                    <div class="panel-body panel-heading">
                        <div class="row">
                            <img class="img-circle profile-img " src="<?= $userHelper->getProfileImage($account->id, $this) ?>" alt="">
                        </div>
                        <div class="row">
                            <h3 class="text-center"><?= $account->username ?></h3> 
                            <p class="text-center"><?= $userHelper->getProfileFullName($account->id) ?></p>
                        </div>

                        <ul class="list-group ">
                            <li class="list-group-item profile-item">
                                <b>Email</b> <a class="pull-right"><?= $account->email ?></a>
                            </li>
                            <li class="list-group-item profile-item">
                                <b>Created</b> <a class="pull-right"><?= Yii::$app->formatter->asDatetime($account->created_at); ?></a>
                            </li>
                            <li class="list-group-item profile-item">
                                <b>Updated</b> <a class="pull-right"><?= Yii::$app->formatter->asDatetime($account->updated_at); ?></a>
                            </li>
                            <li class="list-group-item profile-item">
                                <b>Last Login</b> <a class="pull-right"><?= Yii::$app->formatter->asDatetime($account->last_visited); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>   

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="panel panel-default user-profile-tabs">
                    <div id="profile-tabs" class="container">	
                        <div class="row">
                            <ul  class="nav nav-tabs profile-tab">
                                <li class="active head-tab">
                                    <a href="#account" data-toggle="tab"><i class="fa fa-user"></i> <?= Yii::t('user', 'Account') ?></a>
                                </li>
                                <li class="head-tab" ><a href="#profile" data-toggle="tab"><i class="fa fa-navicon"></i> <?= Yii::t('user', 'Profile') ?></a>
                                </li>
                                <li class="head-tab"><a href="#permissions" data-toggle="tab"><i class="fa fa-flag"></i> <?= Yii::t('user', 'Roles') ?></a>
                                </li>
                            </ul>
                        </div> 

                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="account">
                                <br>
                                <?= $user_html; ?>
                                <br>
                            </div>
                            <div class="tab-pane" id="profile">
                                <br>
                                <?= $profile_html; ?>
                                <br>
                            </div>
                            <div class="tab-pane" id="permissions">
                                <br>
                                <?= $roles_html; ?>
                                <br>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>           

        </div>
    </div>
</div>

