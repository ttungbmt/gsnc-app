<?php

$this->title = 'Thêm mới mẫu nước';
?>
<div class="maunc-create">
    <?= $this->render('_form', [
        'model' => $model,
        'api' => $api,
    ]) ?>
</div>
