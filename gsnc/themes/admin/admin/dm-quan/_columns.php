<?php
use yii\helpers\Url;
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'gid',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tenquan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'maquan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'caphc',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'soho',
//    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'geom',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tenquan_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'order',
    // ],
        [
        'class' => 'kartik\grid\ActionColumn',
        'urlCreator' => function($action, $model, $key, $index) {
                return url([$action,'id' => $key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=> lang('View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=> lang('Update'), 'data-toggle'=>'tooltip'],
    ],

];   