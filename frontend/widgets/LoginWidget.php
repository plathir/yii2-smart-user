<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace plathir\user\frontend\widgets;

use yii\base\Widget;
use Yii;
use plathir\user\frontend\models\security\LoginForm;
use plathir\user\common\models\account\User;

class LoginWidget extends Widget {

    public $Theme = 'smart';
    public $title = 'Login';
    public $selection_parameters = [];

    public function init() {
        parent::init();
        $this->registerTranslations();
        $this->selection_parameters = [
            'title' => Yii::t('user', 'Login'),
            'Theme' => 'smart',
        ];
    }

    public function run() {
        $this->registerClientAssets();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                $user = User::findIdentity(Yii::$app->user->identity->id);
                $user->touch('last_visited');
                Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('user', "Login Failed !"));
                return $this->render('login_widget', [
                            'model' => $model,
                            'widget' => $this
                ]);
            }
        } else {
            return $this->render('login_widget', [
                        'model' => $model,
                        'widget' => $this
            ]);
        }
    }

    public function registerClientAssets() {
        $view = $this->getView();
        $assets = Asset::register($view);
    }

    public function getViewPath() {

        return Yii::getAlias('@vendor') . '/plathir/yii2-smart-user/frontend/widgets/themes/' . $this->Theme . '/views';
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
