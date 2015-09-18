<?php

namespace plathir\user;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\controllers';
    public $adminuserID = '';
  
    public function init() {

        parent::init();
        if ($adminuserID == ''){
          $AdminuserID = '1';  
        }
        $this->registerAssets();
    }

    public function registerAssets() {
        $view = Yii::$app->getView();
        userAsset::register($view);
    }

    
}
