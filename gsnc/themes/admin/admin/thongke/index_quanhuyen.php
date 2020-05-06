<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use ttungbmt\amcharts\AmCharts;

$this->title = 'Thống kê mẫu nước';

$a = 50;
$maquan = request('Maunuoctk.maquan');
//dd(request());
$maphuong = request('Maunuoctk.maphuong');
?>
<?php
//dd($model);
?>
<div class="thongke-form">
    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="card card-white border-left-lg border-left-info">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">
                <span class="font-weight-semibold"><i class="icon-statistics position-left"></i> Thống kê</span>
            </h6>
            <div class="heading-elements">
                <button type="submit" class="btn btn-info btn-labeled btn-labeled-left btn-rounded">
                    <b><i class="icon-graph"></i></b> Thống kê
                </button>
                <a class="btn btn-info btn-labeled btn-labeled-left btn-rounded" download="thongke.xls" href="#"
                   onclick="return ExcellentExport.excel(this, 'tbl-thongke', 'Thongke');"> <b><i
                                class="fa fa-download"></i></b>Tải xuống</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                        'id' => 'maquan',
                        'prompt' => 'Chọn quận...',
                        'value' => $maquan
                    ])->label('Quận') ?>
                </div>
                <div class="col-md-6">

                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options' => ['prompt' => 'Chọn phường...', 'value' => $maphuong],
                        'pluginOptions' => [
                            'initialize' => true,
                            'depends' => ['maquan'],
                            'url' => url(['/api/dm/phuong']),
                            'ajaxSettings' => ['data' => ['value' => $maphuong]]
                        ],
                    ])->label('Phường') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'date_from')->widget(DatePicker::className(), [
                        'type' => DatePicker::TYPE_RANGE,
                        'attribute2' => 'date_to',
                        'options' => ['placeholder' => 'Từ ngày'],
                        'options2' => ['placeholder' => 'Đến ngày']
                    ])->label('Ngày lấy mẫu') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'qcvn_id')->dropDownList(api('dm/qcvn'), ['prompt' => 'Tất cả', 'id' => 'qcvn_id'])->label('QCVN') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'chitieu_id')->widget(DepDrop::className(), [
                        'pluginOptions'=>[
                            'depends'=>['qcvn_id'],
                            'url' => url(['/api/dm/chitieu-by-qcvn'])
                        ]
                    ])?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'loaimau_id')->dropDownList(api('dm/maunc'), ['prompt' => 'Tất cả'])->label('Loại mẫu') ?>
                </div>
            </div>

            <?php if (isset($data) && !empty($data)): ?>
                <hr style="border-style: dashed;">
                <h6 class="text-bold text-center">KẾT QUẢ THỐNG KÊ SỐ LƯỢNG VÀ TỶ LỆ ĐẠT</h6>
                <div class="table-responsive" id="tbl-thongke">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2">STT</th>
                            <th rowspan="2">ĐỊA ĐIỂM</th>
                            <th rowspan="2">SỐ MẪU</th>
                            <th colspan="3">HÓA LÝ</th>
                            <th colspan="3">VI SINH</th>
                            <th colspan="3">CẢ HÓA LÝ VÀ VI SINH</th>
                            <th rowspan="3">Ghi chú</th>
                        </tr>
                        <tr>
                            <?php for ($i = 0; $i < 3; $i++) { ?>
                                <th>Số mẫu đạt</th>
                                <th>Số mẫu không đạt</th>
                                <th>Tỷ lệ đạt (%)</th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $k => $item) { ?>
                            <?php

                            ?>
                            <tr>
                                <td><?= $k + 1 ?></td>
                                <td><?= $item["tenphuong"] ?></td>
                                <td><?= $item["somau"] ?></td>
                                <td><?= $item["hl_dat"] ?></td>
                                <td><?= $item["hl_kdat"] ?></td>
                                <td><?= $item["tyle_hl_dat"] ?></td>
                                <td><?= $item["vs_dat"] ?></td>
                                <td><?= $item["vs_kdat"] ?></td>
                                <td><?= $item["tyle_vs_dat"] ?></td>
                                <td><?= $item["hl_vs_dat"] ?></td>
                                <td><?= $item["hl_vs_kdat"] ?></td>
                                <td><?= $item["tyle_hl_vs_dat"] ?></td>
                                <td></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="2" class="text-center">Tổng</td>
                            <td><?= $data->sum('somau') ?></td>
                            <td><?= $data->sum('hl_dat') ?></td>
                            <td><?= $data->sum('hl_kdat') ?></td>
                            <td><?= number_format($data->avg('tyle_hl_dat')) ?></td>
                            <td><?= $data->sum('vs_dat') ?></td>
                            <td><?= $data->sum('vs_kdat') ?></td>
                            <td><?= number_format($data->avg('tyle_vs_dat')) ?></td>
                            <td><?= $data->sum('hl_vs_dat') ?></td>
                            <td><?= $data->sum('hl_vs_kdat') ?></td>
                            <td><?= number_format($data->avg('tyle_hl_vs_dat')) ?></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (isset($data) && !empty($data)): ?>
                <hr style="border-style: dashed;">
                <div id="chartdiv"
                     style="width: 100%; height: <?= ($data->count() * 50) + 200 ?>px; background-color: #FFFFFF;"></div>
            <?php endif; ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<!-- amCharts javascript sources -->
<script type="text/javascript" src="/libs/bower/excellentexport/dist/excellentexport.js"></script>
<script type="text/javascript" src="/libs/bower/amcharts3/amcharts/amcharts.js"></script>
<script type="text/javascript" src="/libs/bower/amcharts3/amcharts/serial.js"></script>

<?php if (isset($data) && !empty($data)): ?>
    <script type="text/javascript">
        var mang = JSON.parse('<?=json_encode($data)?>');
        // console.log(mang[0].maquan);

        AmCharts.makeChart("chartdiv",
            {
                "type": "serial",
                "rotate": true,
                "categoryField": "tenphuong",
                "startDuration": 1,
                "autoDisplay": true,
                "categoryAxis": {
                    "gridPosition": "start"
                },
                "trendLines": [],
                "graphs": [
                    {
                        "balloonText": "[[title]] của [[category]]:[[value]]",
                        "fillAlphas": 1,
                        "id": "AmGraph-1",
                        "title": "Vi Sinh đạt",
                        "type": "column",
                        "valueField": "vs_dat"
                    },
                    {
                        "balloonText": "[[title]] của [[category]]:[[value]]",
                        "fillAlphas": 1,
                        "id": "AmGraph-2",
                        "title": "Hóa lý đạt",
                        "type": "column",
                        "valueField": "hl_dat"
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "id": "ValueAxis-1",
                        "title": "Số mẫu"
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "legend": {
                    "enabled": true,
                    "useGraphSettings": true
                },
                "titles": [
                    {
                        "id": "Title-1",
                        "size": 15,
                        "text": "BIỂU ĐỒ THỐNG KÊ SỐ MẪU VI SINH VÀ HÓA LÝ ĐẠT"
                    }
                ],
                "dataProvider": mang
            }
        );


    </script>
<?php endif; ?>
