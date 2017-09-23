<?php

namespace plathir\user\backend;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\backend\controllers';
    public $AdminUserID = '';
    public $ProfileImagePath = '';
    public $ProfileImageTempPath = '';
    public $ProfileImagePathPreview = '';
    public $ProfileImageTempPathPreview = '';
    public $Theme = 'smart';

    public function init() {

        parent::init();
        $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-user/backend/themes/' . $this->Theme . '/views';

        $this->setViewPath($path);


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
