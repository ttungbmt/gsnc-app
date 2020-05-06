<?php

use yii\widgets\DetailView;
?>

<div class="dm-phuong-vn-view">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
//            'gid',
//            'ma',
    'ten_tinh',
    'ten_quan',
    'ma_quan',
    'ten',
    'ma_phuong',
//            'ten_en',
    'cap',


//            'ma_tinh',

//            'danso_2016',
//            'danso_tt',
//            'phuong_en',
//            'quan_en',
//            'tinh_en',
//            'soho',
//            'mucchitieu',
//            'dientich_tt',

//            'geom',
//            'v_geom',
    ],
    ]) ?>
</div>

