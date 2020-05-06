<div class="card">
    <div class="card-body">
        <h6 class="font-weight-bold text-center">KẾT QUẢ THỐNG KÊ SỐ LƯỢNG VÀ TỶ LỆ ĐẠT</h6>
        <div class="table-responsive" id="tbl-thongke">
            <table id="tbStat" class="table table-bordered">
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
                    $text = $model->maquan ? ($item["tenphuong"] ? $item["tenphuong"] : $item["maphuong"]) : ($item["tenquan"] ? $item["tenquan"] : $item["maquan"]);
                    ?>
                    <tr>
                        <td><?= $k + 1 ?></td>
                        <td class="font-weight-semibold"><?= $text ?></td>
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
                    <td colspan="2" class="text-center font-weight-bold">Tổng</td>
                    <td class="font-weight-bold"><?= $data->sum('somau') ?></td>
                    <td class="font-weight-bold"><?= $data->sum('hl_dat') ?></td>
                    <td class="font-weight-bold"><?= $data->sum('hl_kdat') ?></td>
                    <td class="font-weight-bold"><?= number_format($data->avg('tyle_hl_dat'), 2) ?></td>
                    <td class="font-weight-bold"><?= $data->sum('vs_dat') ?></td>
                    <td class="font-weight-bold"><?= $data->sum('vs_kdat') ?></td>
                    <td class="font-weight-bold"><?= number_format($data->avg('tyle_vs_dat'), 2) ?></td>
                    <td class="font-weight-bold"><?= $data->sum('hl_vs_dat') ?></td>
                    <td class="font-weight-bold"><?= $data->sum('hl_vs_kdat') ?></td>
                    <td class="font-weight-bold"><?= number_format($data->avg('tyle_hl_vs_dat'), 2) ?></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php if (isset($data) && !empty($data)): ?>
    <hr style="border-style: dashed;">
   <!-- <div id="chartdiv"
         style="width: 100%; height: <?/*= ($data->count() * 50) + 200 */?>px; background-color: #FFFFFF;"></div>-->
<?php endif; ?>