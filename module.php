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
//        $this->modules = [
//            'settings' => [
//                'class' => 'pheme\settings\Module',
//            ],
//        ];
//
//        $this->setComponents([    
//            'settings' => [
//                'class' => 'pheme\settings\components\Settings'
//            ],
//        ]);
//
//        Yii::$app->setComponents([ 'settings' => [
//                'class' => 'pheme\settings\components\Settings'
//            ],
//        ]);

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
