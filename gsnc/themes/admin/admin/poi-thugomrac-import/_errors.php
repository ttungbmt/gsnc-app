<?php
use yii\helpers\Html;
use kartik\alert\Alert;

$errorOptions = [
    'class'  => 'alert alert-danger no-border m-10',
    'header' => (
        '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>' .
        '<p class="font-weight-semibold">Vui lòng sửa các lỗi sau đây: </p>'
    )
];
?>
<style>
    .fade:not(.show){opacity: 1 !important;}
</style>
<?php if(is_string($models)) :?>
    <div class="card-body" style="padding: 10px;">
        <?= Alert::widget([
            'type' => Alert::TYPE_WARNING,
            'title' => 'Lỗi file excel!',
            'icon' => 'glyphicon glyphicon-exclamation-sign',
            'showSeparator' => true,
            'body'    => $models,
        ]) ?>
    </div>
<?php else: ?>
    <?= Html::errorSummary($models, $errorOptions) ?>
<?php endif; ?>

