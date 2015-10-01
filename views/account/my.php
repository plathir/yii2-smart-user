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

<div class="col-lg-3 well" align="center">
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
                        'gender',
                        'birth_date:date',
                        'updated_at:datetime',
                        'created_at:datetime',
                        'updated_by',
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
                    'role',
                    'status',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
    ]);


    $social_html = 'Tab for Social Data';

    $settings_html = 'Tab for User Settings';


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

    <img src=<?php echo $bundle->baseUrl . '/img/user_profile.png'; ?> alt="..." class="img-circle" width="150" align="center" >
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><center><?php echo $account->username; ?></center></th>
        </tr>
        </thead>
        <tbody>

            <tr>
                <td><?php echo '<b>Email : </b>' . $account->email; ?></td>   
            </tr>

            <tr>
                <td><?php echo '<b>Created : </b>' . Yii::$app->formatter->asDatetime($account->created_at); ?></td>   
            </tr>

            <tr>
                <td><?php echo '<b>Updated : </b>' . Yii::$app->formatter->asDatetime($account->updated_at); ?></td>   
            </tr>
            <tr>
                <td><button type="button" class="btn btn-primary">Facebook</button></td>   
            </tr>
            <tr>
                <td><button type="button" class="btn btn-primary">Twitter</button></td>   
            </tr>
            <tr>
                <td><button type="button" class="btn btn-primary">Linkedin</button></td>   
            </tr>
        </tbody>
    </table>

</div>
<div class="col-lg-9">
    <h3>
        My User Data 
    </h3>
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



