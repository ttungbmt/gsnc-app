<?php

use yii\widgets\DetailView;
?>
<div class="dm-quan-view">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
//            'gid',
    'tenquan',
    'maquan',
    'caphc',
//            'soho',
//            'geom',
//            'tenquan_en',
//            'order',
    ],
    ]) ?>
</div>

