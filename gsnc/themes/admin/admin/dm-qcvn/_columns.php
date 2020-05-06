<?php
use yii\helpers\Html;

$columns[] = [
    'class' => 'kartik\grid\SerialColumn',
    'width' => '30px',
];

$columns[] = [
    'class'     => '\kartik\grid\DataColumn',
    'attribute' => 'tenqc',
    'format'    => 'raw',
    'width'     => '250px',
    'value'     => function ($model) {
        $count = count($model->chitieus);
        $text = "{$model->tenqc} ({$count})";
        return Html::a($text, ['/admin/dm-chitieu', 'DmChitieuSearch[qcvn_id]' => $model->getId(), 'invisible' => 'qcvn'], ['data-pjax' => 0]);
    }
];

$columns[] = [
    'class'     => '\kartik\grid\DataColumn',
    'attribute' => 'ghichu',
];

$columns[] = [
    'class'     => '\kartik\grid\BooleanColumn',
    'attribute' => 'status',
];
$columns[] = [
    'class'         => 'kartik\grid\ActionColumn',
    'urlCreator'    => function ($action, $model, $key, $index) {
        return url([$action, 'id' => $key]);
    },
    'viewOptions'   => ['role' => 'modal-remote', 'title' => lang('View'), 'data-toggle' => 'tooltip'],
    'updateOptions' => ['role' => 'modal-remote', 'title' => lang('Update'), 'data-toggle' => 'tooltip'],
];


return $columns;