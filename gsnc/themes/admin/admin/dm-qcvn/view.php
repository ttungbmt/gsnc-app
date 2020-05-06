<?php

use yii\widgets\DetailView;
$this->title = 'Chi tiết QCVN';
?>
<div class="card">
    <div class="card-body">
        <div class="dm-qcvn-view">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'tenqc',
                    'ghichu:ntext',
                    'status',
                    'created_at',
                    'updated_at',
                    'type',
                    'mota:ntext',
                ],
            ]) ?>
        </div>
    </div>
</div>

