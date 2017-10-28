<?php

use yii\helpers\Html;
?>


<?php
if (\Yii::$app->view->theme) {
    $layoutFile = \Yii::$app->view->theme->pathMap['@app/views'] . DIRECTORY_SEPARATOR . 'layouts/main.php';
} else {
    $layoutFile = '@app/views/layouts/main.php';
}
?>

<?php $this->beginContent($layoutFile); ?>
<?php
//backend\assets\AdminLtePluginAsset::register($this);
//backend\assets\AdminLteBowerAsset::register($this);
?>     

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('user', 'Users') ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php
         $htmlFileManager = Html::a(Yii::t('user', '<i class="fa fa-folder-open"></i>File Manager'), ['/user/default/filemanager'], ['class' => 'btn btn-app']); 
         $htmlSettings = Html::a(Yii::t('user', '<i class="fa fa-gears"></i>' . Yii::t('user', 'Settings')), ['/user/settings'], ['class' => 'btn btn-app']);
         $htmlUserManage = Html::a(Yii::t('user', '<i class="fa fa-users"></i>' . Yii::t('user', 'Manage Users')), ['/user/admin'], ['class' => 'btn btn-app']);
         ?>

        <?=  Html::tag('span', $htmlFileManager , ['title' => Yii::t('user', 'Open File Manager'),'data-toggle' => 'tooltip' ]) ?>
        <?=  Html::tag('span', $htmlSettings , ['title' => Yii::t('user', 'Edit Settings for Users'),'data-toggle' => 'tooltip' ]) ?>
        <?=  Html::tag('span', $htmlUserManage , ['title' => Yii::t('user', 'Open User Manager'),'data-toggle' => 'tooltip' ]) ?>
    </div>
</div>
<?php ?>

<?= $content ?>

<?php $this->endContent(); ?>


