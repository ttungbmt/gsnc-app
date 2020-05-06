<?php

use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mamau',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ghichu',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // ],
//    [
//        'class' => '\kartik\grid\BooleanColumn',
//        'attribute' => 'status',
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'urlCreator' => function ($action, $model, $key, $index) {
            return url([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => lang('View'), 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => lang('Update'), 'data-toggle' => 'tooltip'],
    ],

];   