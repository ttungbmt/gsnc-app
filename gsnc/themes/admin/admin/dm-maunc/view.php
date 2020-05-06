<?php

use yii\widgets\DetailView;
?>
<div class="dm-maunc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'mamau',
            'ghichu:ntext',
            'ten',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>
</div>
