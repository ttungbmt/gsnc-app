<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model gsnc\models\PoiBenhvien */

$this->title = $model->gid;
$this->params['breadcrumbs'][] = ['label' => 'Bệnh viện', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="poi-benhvien-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gid',
            'ten',
            'diachi',
            'sonha',
            'tenduong',
            'maquan',
            'maphuong',
            'lat',
            'lng',
            'loaibv',
            'dienthoai',
            'website',
            'lichlamviec',
            'thamkhao',
            'gioithieu:ntext',
            'check',
            'onhiem_id',
            'geom',
            'loaibv_id',
            'created_at',
            'updated_at',
            'status',
            'vs',
            'hl',
            'hl_vs',
            'qcvn_id',
            'ngaylaymau',
            'mamau',
            'loaimau_id',
            'hl_xn',
            'hl_mt',
        ],
    ]) ?>

</div>
