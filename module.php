<?php

namespace plathir\user;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\controllers';
    public $AdminUserID = '';
    public $ProfileImagePath = '';
    public $ProfileImageTempPath = '';
    public $ProfileImagePathPreview = '';

    public function init() {

        parent::init();
        $this->modules = [
            'settings' => [
                'class' => 'pheme\settings\Module',
                'sourceLanguage' => 'en'
            ],
        ];

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
