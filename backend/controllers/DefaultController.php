<?php

namespace plathir\user\backend\controllers;

use yii\web\Controller;
use Yii;

/**
 * AppsController implements the CRUD actions for Apps model.
 * @property \apps\recipes\backend\Module $module
 */
class DefaultController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
        // code for check installed application
        $this->layout = "main";
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'index',
                            'filemanager',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Apps models.
     * @return mixed
     */
    public function actionIndex() {
        if (\yii::$app->user->can('AdminIndexUser')) {
            return $this->render('index');
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user', 'No Permission to View Users'));
        }
    }

    public function actionFilemanager() {
        if (\yii::$app->user->can('AdminIndexUser')) {
        return $this->render('filemanager');
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('user', 'No Permission to File Manager'));
        }        
    }

}
