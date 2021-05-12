<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('user','Login');
//$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div id="site-login-area" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">  
        <div class="panel panel-default">
            <div class="panel-heading"><?=Yii::t('user','Login')?></div>
            <div class="panel-body">                    
                <div class="row">

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'username', [
                            'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>{input}</div>'
                        ])->textInput()->input('username', ['placeholder' => Yii::t('user', "Username")])->label(false);
                        ?>
                    </div>

                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'password', [
                            'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}</div>'
                        ])->passwordInput()->input('password', ['placeholder' => Yii::t('user', "Enter Password")])->label(false);
                        ?>
                    </div>

                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'rememberMe', ['template' => "{input}"])->checkbox([
                            //'class' => 'icheck',
                            'label' => Yii::t('user', 'Remember Me'),
                                //  'labelOptions' => ['style' => "padding-left: 0px;"]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row form-group">
                    <!-- Button -->
                    <div class="col-sm-12 controls">
                        <?= Html::submitButton('<i class="fa fa-sign-in"></i> ' . Yii::t('user', 'Login'), ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
                        <?=
                        ''
//                        yii\authclient\widgets\AuthChoice::widget([
//                            'baseAuthUrl' => ['security/auth'],
//                            'popupMode' => true,
//                        ])
                        ?>

                    </div>
                </div>

                <?php
                $authAuthChoice = yii\authclient\widgets\AuthChoice::begin([
                            'baseAuthUrl' => ['security/auth'],
                            'popupMode' => true,
                ]);
                ?>

                <?php foreach ($authAuthChoice->getClients() as $client): ?>
                    <div class="row form-group">
                        <div class="col-sm-12 controls">
                            <?=
                            $authAuthChoice->clientLink($client, '<span class="fa fa-' . $client->getName() . '"></span> Sign in with ' . $client->getTitle(), [
                                'class' => 'btn btn-primary btn-block btn-social btn-' . $client->getName(),
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>


                <?php yii\authclient\widgets\AuthChoice::end(); ?>  
                <?php ActiveForm::end(); ?>  

                <div class="row">
                    <div class="col-md-12 control">
                        <div>
                            <?= Html::a(Yii::t('user', 'I forgot my password'), ['/user/registration/request-password-reset']) ?>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12 control">
                        <div>
                            <?= Yii::t('user', "Don't have an account ? ") ?>
                            <?= Html::a(Yii::t('user', 'Sign Up Here'), ['/user/registration/signup']) ?>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>        
</div>


