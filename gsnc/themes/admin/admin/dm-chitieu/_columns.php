<?php
use kartik\helpers\Html;

$columns[] = [
    'class' => 'kartik\grid\SerialColumn',
    'width' => '30px',
];
if(request()->get('invisible') !== 'qcvn'){
    $columns[] = [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => $qcvn = 'qcvn_id',
        'value' => 'qcvn.tenqc',
        'filter' => Html::activeDropDownList($searchModel, $qcvn, api('dm/qcvn'), ['prompt' => 'Tất cả', 'class' => 'form-control']),
    ];
}

$columns[] = [
    'class' => '\kartik\grid\DataColumn',
    'attribute' => 'ma',
];

$columns[] = [
    'class' => '\kartik\grid\DataColumn',
    'attribute' => 'tenchitieu',
];

$columns[] = [
    'class' => '\kartik\grid\DataColumn',
    'attribute' => 'val',
    'format' => 'html',
    'label' => 'Giá trị',
    'value' => function($model){
        $from = $model->val_from; $to = $model->val_to; $unit = $model->unit;
        if($from && !$to){
            return "&ge; $from {$unit}";
        } elseif (!$from && $to){
            return "&le; $to {$unit}";
        } elseif (!$from && !$to){
            return null;
        }

        return "{$from} - {$to} {$unit}";
    }
];

$columns[] = [
    'class' => 'kartik\grid\ActionColumn',
    'urlCreator' => function ($action, $model, $key, $index) {
        return url([$action, 'id' => $key]);
    },
    'viewOptions' => ['title' => lang('View'), 'data-toggle' => 'tooltip'],
    'updateOptions' => ['title' => lang('Update'), 'data-toggle' => 'tooltip'],
];

return $columns;