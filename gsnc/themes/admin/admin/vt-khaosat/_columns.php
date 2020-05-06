<?php
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'tenchuho',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'diachi',
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'maquan',
        'value'     => 'tenquan',
        'filter'    => Html::activeDropDownList($searchModel, 'maquan', api('dm_quan'), ['id' => 'maquan1', 'prompt' => 'Tất cả', 'class' => 'form-control']),
        'label'     => 'Quận',
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
        'attribute'           => 'ngaykhaosat',
        'filterType'          => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true
            ],
        ],
    ],
    [
        'class'         => 'kartik\grid\ActionColumn',
        'template'       => '{view} {update} {delete}',
        'urlCreator'    => function ($action, $model, $key, $index) {
            $page=Yii::$app->request->get('page');
            return url([$action, 'id' => $key,'page'=>$page]);
        },
        'viewOptions'   => ['title' => lang('View'), 'data-toggle' => 'tooltip','data-pjax' => 0 ],
        'updateOptions' => ['title' => lang('Update'), 'data-toggle' => 'tooltip'],
        'deleteOptions'  => ['role'                 => 'modal-remote', 'title' => lang('Delete'),
            'data-confirm'         => false,
            'data-method' => false,
            'data-request-method'  => 'post',
            'data-toggle'          => 'tooltip',
            'data-confirm-title'   => lang('Are you sure?'),
            'data-confirm-message' => lang('Are you sure want to delete this item')],
    ],
];