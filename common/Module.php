<?php

namespace plathir\user\common;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\common\controllers';
    public $AdminUserID = '';
    public $ProfileImagePath = '';
    public $ProfileImageTempPath = '';
    public $ProfileImagePathPreview = '';
    public $ProfileImageTempPathPreview = '';

    public function init() {

        parent::init();
        $this->setModules([
            'settings' => [
                'class' => 'plathir\settings\Module',
                'modulename' => 'user'
            ],
        ]);

        $this->setComponents([
            'settings' => [
                'class' => 'plathir\settings\components\Settings',
                'modulename' => 'user'
            ],
        ]);

        if ($this->AdminUserID == '') {
            $this->AdminUserID = '1';
        }
        $this->registerAssets();
    }

    public function registerAssets() {
        $view = Yii::$app->getView();
        userAsset::register($view);
    }

}