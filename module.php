<?php

namespace plathir\user;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\controllers';
  
    public function init() {

        parent::init();

        $this->registerAssets();
    }

    public function registerAssets() {
        $view = Yii::$app->getView();
        userAsset::register($view);
    }

}
