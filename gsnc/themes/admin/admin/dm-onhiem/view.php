<?php

use yii\widgets\DetailView;
?>
<div class="dm-onhiem-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'maloai',
            'ten',
            'mota:ntext',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>
</div>
