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

$this->title = Yii::t('user', 'View User');
$this->params['breadcrumbs'] = [
    ['label' => 'Users', 'url' => ['index']],
    $this->title
];

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

//echo $user_html;

if ($profile) {
    $profile_html = Html::a(Yii::t('user', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update Profile'), ['update-profile', 'id' => $profile->id], ['class' => 'btn btn-success btn-flat btn-loader']) . '&nbsp' .
            Html::a(Yii::t('user', '<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete Profile'), ['delete-profile', 'id' => $profile->id], ['class' => 'btn btn-danger btn-flat btn-loader', 'data-method' => 'post',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) .
            '<br><br>' .
            DetailView::widget([
                'model' => $profile,
                'options' => [
                    'class' => 'table table-striped',
                ],
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
            Html::a(Yii::t('user', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Profile'), ['create-profile', 'id' => $account->id], ['class' => 'btn btn-success btn-flat btn-loader']) .
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

$user_html = Html::a(Yii::t('user', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update User'), ['update', 'id' => $account->id], ['class' => 'btn btn-success btn-flat btn-loader']) . '&nbsp' .
        Html::a(Yii::t('user', '<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete User'), ['delete', 'id' => $account->id], ['class' => 'btn btn-danger btn-flat btn-loader', 'data-method' => 'post',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')]) . '&nbsp' .
        Html::a(Yii::t('user', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Reset Password'), ['reset-password', 'id' => $account->id], ['class' => 'btn btn-warning btn-flat btn-loader']) . '&nbsp' .
        Html::a(Yii::t('user', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Set Password'), ['set-password', 'id' => $account->id], ['class' => 'btn btn-primary btn-flat btn-loader']) . '&nbsp' .
        '<br><br>' .
        $user_html;

$roles_html = Html::a(Yii::t('user', '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Update Roles for user'), ['/admin/assignment/view', 'id' => $account->id], ['class' => 'btn btn-success btn-flat btn-loader']) . '&nbsp' . '<br><br>' .
        $roles_html;
?>

<div class="row">
    <div class="col-md-4">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= $userHelper->getProfileImage($account->id, $this) ?>" alt="User profile picture">
                <h3 class="profile-username text-center"><?= $account->username ?></h3>

                <p class="text-muted text-center"><?= $userHelper->getProfileFullName($account->id) ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Email</b> <a class="pull-right"><?= $account->email ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Created</b> <a class="pull-right"><?= Yii::$app->formatter->asDatetime($account->created_at); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Updated</b> <a class="pull-right"><?= Yii::$app->formatter->asDatetime($account->updated_at); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Last Login</b> <a class="pull-right"><?= Yii::$app->formatter->asDatetime($account->last_visited); ?></a>
                    </li>

                </ul>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#account" data-toggle="tab">Account</a></li>
                <li><a href="#profile" data-toggle="tab">Profile</a></li>
                <li><a href="#roles" data-toggle="tab">Roles</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="account">
                    <?= $user_html; ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="profile">
                    <?= $profile_html; ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="roles">
                    <?= $roles_html; ?>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
