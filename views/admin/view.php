<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;

 
     $user_html = DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'email:email',
                    'role',
                    'status',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
    ]);
     
     echo $user_html;