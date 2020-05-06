<?php

use gsnc\models\Maunc;
use ttungbmt\amcharts\AmCharts;

$vs = collect(Maunc::find()->select('vs val, count(vs)')->groupBy(['vs'])->andFilterDate(['ngaylaymau' => [request('from_date'), request('to_date')]])->asArray()->all());
$hl = collect(Maunc::find()->select('hl val, count(hl)')->groupBy(['hl'])->andFilterDate(['ngaylaymau' => [request('from_date'), request('to_date')]])->asArray()->all());
$get_count = function ($d, $v) {
    return data_get($d->firstWhere('val', $v), 'count');
};
$data = [
    [
        'category' => 'VS',
        'dat'      => $get_count($vs, 1),
        'kdat'     => $get_count($vs, 0)
    ],
    [
        'category' => 'HL',
        'dat'      => $get_count($hl, 1),
        'kdat'     => $get_count($hl, 0)
    ],
];
?>

<?= AmCharts::widget([
    'valueAxes'            => [
        [
            'title'     => 'Số lượng',
            'stackType' => 'regular'
        ]
    ],
    'defaultPluginOptions' => [
        "categoryField" => "category",
        "rotate"        => true,
        "angle"         => 25,
        "depth3D"       => 20,
        "graphs"        => [
            [
                'type'        => 'column',
                'valueField'  => 'dat',
                'fillAlphas'  => 1,
                'title'       => 'Đạt',
                'columnWidth' => 0.5,
                'labelText'   => '[[value]]'
            ],
            [
                'type'        => 'column',
                'valueField'  => 'kdat',
                'fillAlphas'  => 1,
                'title'       => 'Không đạt',
                'columnWidth' => 0.5,
                'labelText'   => '[[value]]'
            ]
        ],
        "legend"        => [
            "enabled"          => true,
            "useGraphSettings" => true
        ],
        'dataProvider'  => $data
    ]
]) ?>