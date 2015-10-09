<?php

namespace plathir\user\controllers;

use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\profile\UserProfile;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;

/**
 * @property \plathir\user\Module $module
 * 
 */
class ImagetestController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
    }

    public function actions() {
        return [
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => 'media/images/users'
            ]
        ];
    }

    /** @inheritdoc */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
                            'update',
                            'view'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    function actionIndex() {

        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
        ]);
    }

    function actionCreate($id) {
        
    }

    function actionUpdate($id) {
        
        
        
        return $this->render('update', [
                    'profile' => $this->findModelProfile($id),
                    'module' => $this->module,
        ]);
    }

    function actionView($id) {
        return $this->render('view', [
                    'profile' => $this->findModelProfile($id),
                    'module' => $this->module,
        ]);
    }

    function findModelProfile($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

}
