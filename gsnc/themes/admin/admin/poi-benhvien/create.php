<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model gsnc\models\PoiBenhvien */

$this->title = 'Thêm mới bệnh viện';
?>
<div class="poi-benhvien-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
