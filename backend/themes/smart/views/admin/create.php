<?php
/*
 *  Create User ( Admin )
 * 
 *  
 */

$this->title = Yii::t('user', 'Create User');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-account-index">
    <?php
    echo $this->render('_form', [
        'account' => $account,
    ]);
    ?>  
</div>

