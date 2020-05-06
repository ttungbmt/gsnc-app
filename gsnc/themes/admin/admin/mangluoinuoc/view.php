<?php

use yii\widgets\DetailView;
?>
<div class="mangluoinuoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gid',
            'objectid',
            'idmaduongo',
            'idcapnuoc',
            'huongdongc',
            'chieudai',
            'vatlieu',
            'tieuchuan',
            'hieu',
            'nuocsanxua',
            'donhamthuc',
            'aplucthiet',
            'namlapdat',
            'vitrilapda',
            'dosau',
            'dodoc',
            'donhamdanh',
            'tinhtrang',
            'alhoatdong',
            'dktrong',
            'dkngoai',
            'coong',
            'capong',
            'loaiongnuo',
            'shape_leng',
            'shape_le_1',
            'id',
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>
