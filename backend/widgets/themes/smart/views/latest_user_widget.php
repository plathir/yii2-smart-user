<?php

use yii\helpers\Html;
use plathir\user\common\helpers\UserHelper;
$userHelper = new UserHelper();

?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Yii::t('user', $widget->title ) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                    <tr>
                        <th><?=Yii::t('user','Image'); ?></th>
                        <th><?=Yii::t('user','User ID'); ?></th>
                        <th><?=Yii::t('user','Username'); ?></th>
                        <th><?=Yii::t('user','Email'); ?></th>
                        <th><?=Yii::t('user','Created Date');?></th>
                        <th><?=Yii::t('user','Last Login'); ?></th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($users) {
                    foreach ($users as $user) { ?>
                        <tr>
                            <td>
                            <?=
                            Html::img($userHelper->getProfileImage($user->id, $this), ['alt' => '...',
                                        'class' => 'img-circle',
                                        'width' => '30',
                                        'align' => 'center']);
                            ?>
                            </td>
                            <td><?= $user->id ?></td>

                            <td><?= Html::a($user->username, ['/user/admin/view', 'id' => $user->id]) ?></td>
                            <td><?= $user->email; ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($user->created_at) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($user->last_visited) ?></td>
                        </tr>
                    <?php } 
                    }
                    ?>
                </tbody>
            </table>
        </div><!-- /.table-responsive -->
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
        <?= Html::a(Yii::t('user', 'Create New User'), ['/user/admin/create'], ['class' => 'btn btn-sm btn-info btn-flat pull-left']) ?>  
        <?= Html::a(Yii::t('user', 'View All Users'), ['/user/admin'], ['class' => 'btn btn-sm btn-default btn-flat pull-right']) ?>
    </div><!-- /.box-footer -->
</div><!-- /.box -->        
