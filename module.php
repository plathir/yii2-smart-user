<?php

namespace plathir\user;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\controllers';
    public $AdminUserID = '';
    public $alias = '';
    public $ProfileImagePath = '@web';
  
    public function init() {

        parent::init();
        
        if ($this->AdminUserID == ''){
          $this->AdminUserID = '1';  
        }
        $this->registerAssets();
    }

    public function registerAssets() {  
        $view = Yii::$app->getView();
        userAsset::register($view);
    }

    
}
