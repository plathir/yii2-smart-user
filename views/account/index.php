<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;

//Modal::begin([
//    'header' => '<h2>Hello world</h2>',
//    'toggleButton' => ['label' => 'click me'],
//]);

echo '<h3>Index Account</h3>';

echo Html::a('Account Edit', ['edit']);
echo '<br>';
echo Html::a('Change Password', ['change-password']);

//
//Modal::end();

