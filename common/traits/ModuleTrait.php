<?php

namespace plathir\user\common\traits;

use plathir\user\common\Module;
use Yii;

/**
 * Class ModuleTrait
 * @package plathir\users\common\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait {

    /**
     * @var \plathir\users\Module|null Module instance
     */
    private $_module;

    /**
     * @return \plathir\users\common\Module|null Module instance
     */
    public function getModule() {
        if ($this->_module === null) {
            $module = Module::getInstance();
            if ($module instanceof Module) {
                $this->_module = $module;
            } else {
                $this->_module = Yii::$app->getModule('user');
            }
        }
      //  print_r($this->_module);
      //  die();
        return $this->_module;
        
    }

}
