<?php

use kartik\widgets\DepDrop;
use kartik\helpers\Html;
use yii\data\Pagination;
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'ten',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'diachi',
    ],
    [
        'class'              => '\kartik\grid\DataColumn',
        'attribute'          => 'maquan',
        'value'              => 'tenquan',
        'filter'             => api('dm_quan'),
        'filterInputOptions' => ['id' => 'maquan1', 'prompt' => 'Tất cả', 'class' => 'form-control'],
        'label'              => 'Quận',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'label'     => 'Phường',
        'attribute' => 'maphuong',
        'value'     => 'tenphuong',
        'filter'    => DepDrop::widget([
            'attribute'     => 'maphuong',
            'model'         => $searchModel,
            'options'       => ['prompt' => 'Tất cả...', 'id' => 'maphuong1'],
            'pluginOptions' => [
                'depends' => ['maquan1'],
                'url'     => url(['/api/dm/phuong']),
            ]
        ]),
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'sonha',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'tenduong',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'onhiem',
        'label'     => 'Loại ô nhiễm',
        'filter'    => Html::activeDropDownList($searchModel, 'onhiem_id', api('dm/onhiem'), ['prompt' => 'Tất cả', 'class' => 'form-control']),
    ],
    [
        'class'         => 'kartik\grid\ActionColumn',
        'urlCreator'    => function ($action, $model, $key, $index) {
            $page=Yii::$app->request->get('page');

            return url([$action, 'id' => $key,'page'=>$page]);
        },
        'viewOptions'   => ['title' => lang('View'), 'data-toggle' => 'tooltip'],
        'updateOptions' => ['title' => lang('Update'), 'data-toggle' => 'tooltip'],
    ],

];   