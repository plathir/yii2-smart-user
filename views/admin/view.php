<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Tabs;

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
                'role',
                'status',
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
                    'gender',
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
?>
<div class="col-lg-3 well" align="center">
    <?php $bundle = plathir\user\userAsset::register($this); ?>
    <?php
    if ($profile) {
        if ($profile->profile_image == '') {
            ?>
            <img src=<?php echo $bundle->baseUrl . '/img/user_profile.png'; ?> alt="..." class="img-circle" width="150" align="center" >
        <?php } else { ?>
            <img src=<?php echo yii::getAlias($module->ProfileImagePathPreview) . '/' . $profile->profile_image; ?> alt="..." class="img-circle" width="150" align="center" >
            <?php
        }
    } else {
        ?>
        <img src=<?php echo $bundle->baseUrl . '/img/user_profile.png'; ?> alt="..." class="img-circle" width="150" align="center" >
        <?php
    }
    ?>
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
        Data for user : <?= $account->username; ?> 
    </h3>
    <div>
        <?php
        echo Tabs::widget([
            'items' => $items,
        ]);
        ?>
        <?php //echo yii::getAlias($module->ProfileImagePath); ?>  
    </div>
</div>


