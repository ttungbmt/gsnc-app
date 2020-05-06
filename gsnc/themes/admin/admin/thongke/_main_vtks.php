<?php
use gsnc\models\VtKhaosat;
?>
    <div class="card">
        <div class="card-body">
            <h6 class="text-bold text-center">KẾT QUẢ THỐNG KÊ SỐ LƯỢNG VÀ TỶ LỆ ĐẠT</h6>
            <div class="table-responsive" id="tbl-thongke">
                <table id="tbStat" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th style="width: 150px">Địa điểm</th>
                        <th>Số lượng vị trí khảo sát</th>
                        <th>Số lượng nguồn nước đang sử dụng là nước máy</th>
                        <th>Số lượng hộ dân hài lòng  về nguồn nước đang sử dụng</th>
                        <th>Số lượng vị trí khảo sát sử dụng nước qua bồn chứa</th>
                        <th>Số lượng hộ dân có thực hiện vệ sinh bồn chứa</th>
                        <th>Số lượng vị trí khảo sát đạt</th>
                        <th>Số lượng vị trí khảo sát không đạt</th>
                        <th>Tỷ lệ đạt (%)</th>
                        <th>Ghi chú</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $k => $i):?>
                        <tr>
                            <td><?= $k + 1 ?></td>
                            <td class="font-weight-semibold"><?= $model->maquan ? $i["tenphuong"] : $i["tenquan"] ?></td>
                            <td><?=$i['count']?></td>
                            <td><?=$i['ct1']?></td>
                            <td><?=$i['ct2']?></td>
                            <td><?=$i['ct3']?></td>
                            <td><?=$i['ct4']?></td>
                            <td><?=$i['dat']?></td>
                            <td><?=$i['kdat']?></td>
                            <td><?=$i['tyle']?></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" class="text-center font-weight-semibold">Tổng</td>
                        <td><?=$data->sum('count')?></td>
                        <td><?=$data->sum('ct1')?></td>
                        <td><?=$data->sum('ct2')?></td>
                        <td><?=$data->sum('ct3')?></td>
                        <td><?=$data->sum('ct4')?></td>
                        <td><?=$data->sum('dat')?></td>
                        <td><?=$data->sum('kdat')?></td>
                        <td><?= number_format($data->avg('tyle'), 2) ?></td>
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