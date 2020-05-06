<?php
use yii\helpers\Url;
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'idmaduongo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'idcapnuoc',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'huongdongc',
    ],
//     [
//         'class'=>'\kartik\grid\DataColumn',
//         'attribute'=>'chieudai',
//     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'tieuchuan',
     ],
//     [
//         'class'=>'\kartik\grid\DataColumn',
//         'attribute'=>'namlapdat',
//     ],
//     [
//         'class'=>'\kartik\grid\DataColumn',
//         'attribute'=>'vitrilapda',
//     ],
//     [
//         'class'=>'\kartik\grid\DataColumn',
//         'attribute'=>'tinhtrang',
//     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'coong',
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'capong',
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'loaiongnuo',
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shape_leng',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shape_le_1',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'geom',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    [
        'width' => '100px',
        'class' => 'kartik\grid\ActionColumn',
        'urlCreator' => function($action, $model, $key, $index) {
                return url([$action,'id' => $key]);
        },
        'viewOptions'=>['title'=> lang('View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=> lang('Update'), 'data-toggle'=>'tooltip'],
    ],

];   