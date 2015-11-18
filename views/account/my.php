<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
?>

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="text-center">
            <?php $bundle = plathir\user\userAsset::register($this); ?>

            <?php
            if ($profile != null) {
                $profile_html = Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Profile', ['value' => Url::to(['user-profile/edit-my-profile']), 'class' => 'btn btn-success', 'id' => 'modalButtonProfile']) .
                        '&nbsp' .
                        Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true" ></span> Delete Profile', ['user-profile/delete-my-profile'], ['class' => 'btn btn-danger',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'id' => 'ButtonProfile1',
                            'data-method' => 'post',
                            'data-pjax' => '0'
                        ]) .
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
                                'birth_date:date',
                                'updated_at:datetime',
                                'created_at:datetime',
                                [
                                    'label' => 'Updated by',
                                    'attribute' => 'updated_by',
                                    'value' => $profile->getUpadatedByUserName(),
                                ],
                            ],
                ]);
            } else {
                $profile_html = 'Profile not update yet ! <br> <br>' .
                        Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit Profile', ['value' => Url::to(['user-profile/create-my-profile']), 'class' => 'btn btn-success', 'id' => 'modalButtonProfile']) .
                        '<br><br>';
            }

            $account_html = DetailView::widget([
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
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
            ]);


            $social_html = 'Tab for Social Data';

            $settings_html = 'Tab for User Settings';
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
                Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Account Edit', ['value' => Url::to(['edit']), 'class' => 'btn btn-success', 'id' => 'modalButtonAccount']) .
                '&nbsp ' .
                Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change Password', ['value' => Url::to(['change-password']), 'class' => 'btn btn-danger', 'id' => 'modalButtonChangePass']) .
                '<br><br>' . $account_html,
                    //            'headerOptions' => ['class'=>"col-lg-3"],
            ];

            $items[] = [
                'label' => '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Profile',
                'encode' => false,
                'content' => '<br>' .
                $profile_html,
                //   'headerOptions' => ['class'=>"col-lg-3"],
                'options' => ['id' => 'profileTab'],
            ];

            $items[] = [
                'label' => '<span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Roles',
                'encode' => false,
                'content' => '<br>' .
                $roles_html,
                //   'headerOptions' => ['class'=>"col-lg-3"],
                'options' => ['id' => 'rolesTab'],
            ];

            $items[] = [
                'label' => '<span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Social',
                'encode' => false,
                'content' => '<br>' .
                $social_html,
                //   'headerOptions' => ['class'=>"col-lg-3"],
                'options' => ['id' => 'socialTab'],
            ];

            $items[] = [
                'label' => '<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings',
                'encode' => false,
                'content' => '<br>' .
                $settings_html,
                //   'headerOptions' => ['class'=>"col-lg-3"],
                'options' => ['id' => 'settingsTab'],
            ];
            ?>


            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <?php
                    echo Html::img(\plathir\user\helpers\UserHelper::getProfileImage(Yii::$app->user->identity->id, $this), ['alt' => '...',
                        'class' => 'img-circle',
                        'width' => '100',
                        'align' => 'center']);
                    ?>

                </div>
                <div class="panel-body">
                    <p><b><?= '(' . Yii::$app->user->identity->username . ')' ?> 
                            <?= \plathir\user\helpers\UserHelper::getProfileFullName(Yii::$app->user->identity->id) ?></b></p>
                </div>

                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item"><?php echo '<b>Email : </b>' . $account->email; ?></li>
                    <li class="list-group-item"><?php echo '<b>Created : </b>' . Yii::$app->formatter->asDatetime($account->created_at); ?></li>
                    <li class="list-group-item"><?php echo '<b>Updated : </b>' . Yii::$app->formatter->asDatetime($account->updated_at); ?></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="col-md-9 col-sm-6 col-xs-12 personal-info">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">        
                <h3>
                    My User Data 
                </h3>
            </div>
            <div class="panel-body">     
                <div>
                    <?php
                    echo Tabs::widget([
                        'items' => $items,
                    ]);
                    ?>
                </div>

                <?php
// Display modal Account edit
                Modal::begin([
                    'header' => '<h4>Account Edit</h4>',
                    'id' => 'modalAccount',
                    'size' => 'modal-sm',
                    'footer' => 'Footer modal'
                ]);
                echo "<div id='modalContentAccount'> </div>";
                Modal::end();
                ?>
                <?php
                // Display change Password edit
                Modal::begin([
                    'header' => '<h4>Change Password</h4>',
                    'id' => 'modalChangePass',
                    'size' => 'modal-sm',
                    'footer' => 'Footer modal'
                ]);
                echo "<div id='modalContentChangePass'> </div>";
                Modal::end();
                ?>

                <?php
                Modal::begin([
                    'header' => '<h4>Edit Profile</h4>',
                    'id' => 'modalProfile',
                    'size' => 'modal-md',
                    'footer' => 'Footer modal'
                ]);
                echo "<div id='modalContentProfile'> </div>";
                Modal::end();
                ?>
            </div>    
        </div>
    </div>

</div>

