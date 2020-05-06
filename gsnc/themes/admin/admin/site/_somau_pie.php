<?php

use gsnc\models\Maunc;
use ttungbmt\amcharts\AmCharts;
$data = Maunc::find()->select('hl_vs, count(*)')->groupBy(['hl_vs'])->andFilterDate(['ngaylaymau' => [request('from_date'), request('to_date')]])->asArray()->all();
$data = collect($data)->map(function ($i){
   return [
       'category' => $i['hl_vs'] == 1 ? 'HL+VS đạt' : 'HL+VS k đạt',
       'count' => $i['count'],
   ];
});
?>
<?php if($data->isEmpty()):?>
<div class="m-2">Không có dữ liệu</div>
<?php else:?>
    <?= AmCharts::widget([
        'height' => '200px',
        'defaultPluginOptions' => [
            'type' => 'pie',
            "angle"         => 25,
            "depth3D"       => 10,
            "titleField" => "category",
            "maxLabelWidth" => 100,
            "valueField" => "count",
            'dataProvider' => $data
        ]
    ]) ?>
<?php endif;?>
