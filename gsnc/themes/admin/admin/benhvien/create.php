<?php

use yii\helpers\Html;

$this->title = 'Thêm mới mẫu nước thải';
?>
<div class="benhvien-create">
    <?= $this->render('_form', [
        'model' => $model,
        'api' => $api,
    ]) ?>

</div>
