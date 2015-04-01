<?php

namespace plathir\user\controllers;

use yii\web\Controller;

class DefaultController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionNewpost() {

        return $this->render('newuser');
    }

}
