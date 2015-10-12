<?php

namespace plathir\user\traits;

use plathir\user\Module;
use Yii;

/**
 * Class ModuleTrait
 * @package plathir\users\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait
{
    /**
     * @var \plathir\users\Module|null Module instance
     */
    private $_module;

    /**
     * @return \plathir\users\Module|null Module instance
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $module = Module::getInstance();
            if ($module instanceof Module) {
                $this->_module = $module;
            } else {
                $this->_module = Yii::$app->getModule('user');
            }
        }
        return $this->_module;
    }
}
