<?php

namespace plathir\user\backend\widgets;

use yii\base\Widget;
use yii\base\InvalidConfigException;
use plathir\user\common\helpers\UserHelper;
use Yii;

class LatestUsers extends Widget {

    public $latest_num = 10;
    public $Theme = 'smart';
    public $title = 'Latest Users';
    public $selection_parameters = [];

    public function init() {
        parent::init();
        $this->selection_parameters = [
            'latest_num' => $this->latest_num,
            'Theme' => $this->Theme,
        ];
        
    }

    public function run() {
        $this->registerClientAssets();
        $helper = new UserHelper();
        $users = $helper->getLatestUsers($this->latest_num);

        return $this->render('latest_user_widget', [
                    'users' => $users,
                    'widget' => $this
        ]);
    }

    public function registerClientAssets() {
        $view = $this->getView();
        $assets = Asset::register($view);
    }

    public function getViewPath() {

        return Yii::getAlias('@vendor') . '/plathir/yii2-smart-user/backend/widgets/themes/' . $this->Theme . '/views';
    }
    
}
