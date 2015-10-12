<?php

namespace plathir\user\controllers;

use Yii;
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
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@web/media/images/users',
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
                echo '<pre>';
                print_r($model);
                echo '</pre>';
                die();
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
