<?php
use yii\helpers\Url;
use kartik\widgets\DepDrop;

use kartik\helpers\Html;


$dmQuan = app('api')->get('dm_quan');
$selectOptions = ['prompt' => 'Tất cả', 'class' => 'form-control'];

$depdrop = DepDrop::widget([
    'attribute'     => 'maphuong',
    'model'         => $searchModel,
    'options'       => ['prompt' => 'Chọn phường...'],
    'pluginOptions' => [
        'depends' => ['maquan'],
        'url'     => url(['/api/dm/phuong']),]
]);
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
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'maquan',
        'value'     => 'tenquan',
        'filter'    => Html::activeDropDownList($searchModel, 'maquan', $dmQuan, $selectOptions + ['id' => 'maquan']),
        'label'     => 'Quận'
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'maphuong',
        'value'     => 'tenphuong',
        'filter'    => $depdrop,
        'label'     => 'Phường'
    ],
    [
        'class'     => '\kartik\grid\DataColumn',
        'attribute' => 'loaionhiem',
        'label'     => 'Loại ô nhiễm',
        'filter'    => Html::activeDropDownList($searchModel, 'onhiem_id', api('dm/onhiem'), ['id' => 'loaionhiem', 'prompt' => 'Tất cả', 'class' => 'form-control']),
    ],
//    [
//        'class'     => '\kartik\grid\DataColumn',
//        'attribute' => 'ghichu',
//    ],
    [
        'class'         => 'kartik\grid\ActionColumn',
        'urlCreator'    => function ($action, $model, $key, $index) {
            $page=Yii::$app->request->get('page');

            return url([$action, 'id' => $key,'page'=>$page]);
        },
        'viewOptions'   => [ 'title' => lang('View'), 'data-toggle' => 'tooltip'],
        'updateOptions' => ['title' => lang('Update'), 'data-toggle' => 'tooltip'],
    ],

];