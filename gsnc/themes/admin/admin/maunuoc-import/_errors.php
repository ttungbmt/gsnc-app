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
    <?php $messages = collect($models)->map(function ($i, $r){
        $m = [];
        foreach ($i->getErrors() as $k => $v){
            $m[] = '(<u>'.$i->{$k}.'</u>) '.implode($v, ', ');
        };
        $e = trim(implode($m, ', '));
        return $e ? '<b>Dòng '.($r+1).'</b>: '.$e : null;
    })->filter();?>
    <?php if($messages->isNotEmpty()):?>
     <div class="alert alert-danger border-0 alert-dismissible m-2">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold">Vui lòng sửa các lỗi sau!</span>.
        <ul>
            <?php foreach ($messages as $m):?>
            <li><?=$m?></li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php endif;?>
<?php endif; ?>

