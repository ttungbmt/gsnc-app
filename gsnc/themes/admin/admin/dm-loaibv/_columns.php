<?php

use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'maloai',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ten',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mota',
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'urlCreator' => function ($action, $model, $key, $index) {
            return url([$action, 'id' => $key]);
        },
        'viewOptions' => ['title' => lang('View'), 'data-toggle' => 'tooltip'],
        'updateOptions' => ['title' => lang('Update'), 'data-toggle' => 'tooltip'],
    ],

];