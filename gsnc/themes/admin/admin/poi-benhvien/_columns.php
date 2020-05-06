<?php

return [
    ['class' => 'yii\grid\SerialColumn'],
    'ten',
    'diachi',
    'sonha',
    'tenduong',
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