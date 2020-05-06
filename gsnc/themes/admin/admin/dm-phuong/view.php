<?php

use yii\widgets\DetailView;
?>

<div class="dm-phuong-view">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
//            'gid',
    'tenquan',
    'maquan',
    'tenphuong',
    'maphuong',
    'caphc',
//            'soho',
//            'geom',
//            'tenphuong_en',
//            'tenquan_en',
//            'tenphuong_format',
//            'tenquan_format',
//            'order',
    ],
    ]) ?>
</div>


