<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;

$this->title = Yii::t('user', 'Update user : ' . $account->username );

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('user', 'Index Users'), 'url' => ['index']],
    ['label' => Yii::t('user', 'View User :') . $account->id,
        'url' => ['view', 'id' => $account->id]
    ],
    $this->title
];
?>

<div class="user-account-update">
    <?php
    echo $this->render('_form_update', [
        'account' => $account,
    ]);
    ?>   
</div>
