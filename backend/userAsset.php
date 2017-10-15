<?php

namespace plathir\user\backend;

use yii\web\AssetBundle;

class userAsset extends AssetBundle {

    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    //    'yii\web\JqueryAsset',
    ];

    public function init() {
        parent::init();        
        $this->setSourcePath('@vendor/plathir/yii2-smart-user/common/assets');

    }

    protected function setSourcePath($path) {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        } else {
            $this->sourcePath = '';
        }
    }

}
