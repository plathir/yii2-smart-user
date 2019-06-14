<?php
namespace plathir\user\frontend;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\user\frontend\controllers';
    public $AdminUserID = '';
    public $ProfileImagePath = '';
    public $ProfileImageTempPath = '';
    public $ProfileImagePathPreview = '';
    public $ProfileImageTempPathPreview = '';
    public $Theme = 'smart';
    public $mediaUrl = '';
    public $mediaPath = '';
    public $DefaultRoles = '';

    public function init() {
//        $themeHelper = new \frontend\helpers\ThemesHelper();
//        $this->themePath = $themeHelper->ModuleThemePath('user','frontend', __FILE__);
        //$path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-user/frontend/themes/' . $this->Theme . '/views';

        if (Yii::$app->settings->getSettings('FrontEndTheme') != null) {
            $path = Yii::getAlias('@realAppPath') . '/themes/site/' . Yii::$app->settings->getSettings('FrontendTheme') . '/module/user/views';
        } else {
            $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-user/frontend/themes/' . $this->Theme . '/views';
        }

        $this->setViewPath($path);

        parent::init();
        $this->setModules([
            'settings' => [
                'class' => 'plathir\settings\backend\Module',
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
        $this->registerTranslations();
    }

    public function registerTranslations() {
        /* This registers translations for the widgets module * */
        Yii::$app->i18n->translations['user'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => Yii::getAlias('@vendor/plathir/yii2-smart-user/frontend/messages'),
        ];
    }

}
