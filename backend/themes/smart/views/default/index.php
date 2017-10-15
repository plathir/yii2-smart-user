<?php

use yii\helpers\Html;
use plathir\widgets\common\helpers\PositionHelper;
$positionHelper = new PositionHelper();

?>

<div class="user-default-index">
    <div class="row">
        <div class="col-lg-12">        
            <?= $positionHelper->LoadPosition('be_user_dashboard'); ?>
        </div>
    </div>
</div>  