<?php

use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;


return [
    [
        'class' => 'kartik\grid\SerialColumn',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'maquan',
        'value' => 'tenquan',
        'filter' => api('dm_quan'),
        'filterInputOptions' => ['id' => 'maquan1', 'prompt' => 'Tất cả', 'class' => 'form-control'],
        'label' => 'Quận',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Phường',
        'attribute' => 'maphuong',
        'value' => 'tenphuong',
        'filter' => DepDrop::widget([
            'attribute' => 'maphuong',
            'model' => $searchModel,
            'options' => ['prompt' => 'Tất cả...', 'id' => 'maphuong1'],
            'pluginOptions' => [
                'depends' => ['maquan1'],
                'url' => url(['/api/dm/phuong']),
            ]
        ]),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'loaimau',
        'filter' => Html::activeDropDownList($searchModel, 'loaimau_id', api('dm/maunc'), ['id' => 'loaimau', 'prompt' => 'Tất cả', 'class' => 'form-control']),
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'mamau',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'diachi',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'ngaylaymau',
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true
            ],
        ],
    ],

    [
        'label' => 'Kết quả xét nghiệm',
        'attribute' => 'hl_vs',
        'format' => 'raw',
        'filter' => ['1' => 'Đạt', '0' => 'Không'],
        'filterInputOptions' => ['prompt' => 'Tất cả', 'class' => 'form-control'],
        'value' => function ($model, $key, $index, $column) {
            list($color, $message) =
                $model->hl_vs ? ['primary', 'Đạt'] : ['danger', 'Không đạt'];
            return "<span class='badge badge-{$color}'>{$message}</span>";
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {update} {delete}',
        'urlCreator' => function ($action, $model, $key, $index) {
            $page = Yii::$app->request->get('page');
            return url([$action, 'id' => $key,'page'=>$page]);
        },
        'viewOptions' => ['title' => lang('View'), 'data-toggle' => 'tooltip'],
        'updateOptions' => ['title' => lang('Update'), 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => lang('Delete'),
            'data-confirm' => false,
            'data-method' => false,
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => lang('Are you sure?'),
            'data-confirm-message' => lang('Are you sure want to delete this item')],
    ],
];