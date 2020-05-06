<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model gsnc\models\PoiBenhvien */

$this->title = 'Cập nhật bệnh viện: ' . $model->gid;
?>
<div class="poi-benhvien-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
