<?php

namespace plathir\user\common;

use yii\web\AssetBundle;

class userAsset extends AssetBundle {

    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {
        $this->setSourcePath('@vendor/plathir/yii2-smart-user/common/assets');
        parent::init();
    }

    protected function setSourcePath($path) {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        } else {
            $this->sourcePath = '';
        }
    }

}
