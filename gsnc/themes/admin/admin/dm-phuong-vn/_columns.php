<?php
use yii\helpers\Url;
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
//        [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'gid',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'ma',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_tinh',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten_quan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma_quan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ten',
    ],
    [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'ma_phuong',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'ten_en',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cap',
    ],


//     [
//         'class'=>'\kartik\grid\DataColumn',
//         'attribute'=>'ma_tinh',
//     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'danso_2016',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'danso_tt',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'phuong_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'quan_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tinh_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'soho',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'mucchitieu',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'dientich_tt',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'geom',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'v_geom',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'visibleButtons' => [
            'update'  => can('poi_raumau'),
            'delete'  => can('poi_raumau'),
        ],
        'urlCreator' => function($action, $model, $key, $index) {
                return url([$action,'id' => $key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=> lang('View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=> lang('Update'), 'data-toggle'=>'tooltip'],

    ],

];   