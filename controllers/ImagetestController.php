<?php

namespace plathir\user\controllers;

use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use plathir\user\models\ImagetestForm;
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
                'path' => '@web/media/images/users',
            ],
            'upload' => [
                'class' => 'vova07\fileapi\actions\UploadAction',
                'path' => '@web/media/images/users',
                'uploadOnlyImage' => false
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
                            'view',
                            'fileapi-upload',
                            'upload'
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
        $model = $this->findModelProfile($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->update()) {
                Yii::$app->getSession()->setFlash('success', 'Profile changed !');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Profile cannot change !');
                return $this->redirect(['update', 'id' => $id]);
            }
        } else {
            return $this->render('update', [
                        'profile' => $this->findModelProfile($id),
                        'module' => $this->module,
            ]);
        }
    }

    function actionView($id) {
        return $this->render('view', [
                    'profile' => $this->findModelProfile($id),
                    'module' => $this->module,
        ]);
    }

    function findModelProfile($id) {
        if (($model = ImagetestForm::findOne($id)) !== null) {
            return $model;
        } else {
            return false;
        }
    }

}
