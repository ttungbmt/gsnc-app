<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
\yii\grid\GridViewAsset::register($this);
?>
<?php Pjax::begin([
    'id'              => $pjax_id = $data['pjax_id'],
    'enablePushState' => false,
]) ?>

<div class="kv-loader-overlay">
    <div class="kv-loader"></div>
</div>
<?= ListView::widget([
    'layout'       => "{items}\n{pager}",
    'dataProvider' => $dataProvider,
    'itemView'     => '_list_item',
    'viewParams' => ['data' => $data],
    'pager'        => [
        'options' => [
            'class' => 'pagination mt-10'
        ]
    ],
]) ?>
<script>
    $('#<?=$pjax_id?>').data(<?=json_encode($data) ?>)
</script>
<?php Pjax::end() ?>






