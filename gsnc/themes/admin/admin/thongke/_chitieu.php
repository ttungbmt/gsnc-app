<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tbStat" class="table">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Địa điểm</th>
                    <th>Chi tiêu đo</th>
                    <th>Số mẫu đo</th>
                    <th>Số mẫu đạt</th>
                    <th>Số mẫu không đạt</th>
                    <th>Tỷ lệ đạt (%)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $k => $d):?>
                    <tr>
                        <td><?=$k+1?></td>
                        <td><?=$location?></td>
                        <td><?=$d['tenchitieu']?></td>
                        <td><?=$d['count'] ? $d['count'] : 0?></td>
                        <td><?=$d['dat'] ? $d['dat'] : 0?></td>
                        <td><?=$d['kdat'] ? $d['kdat'] : 0?></td>
                        <td><?=$d['count'] == 0 ? '0' : round(($d['dat']/$d['count'])*100, 2)?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="font-weight-semibold" colspan="3">Tổng cộng</td>
                    <td class="font-weight-semibold"><?=$data->sum('count')?></td>
                    <td class="font-weight-semibold"><?=$data->sum('dat')?></td>
                    <td class="font-weight-semibold"><?=$data->sum('kdat')?></td>
                    <td class="font-weight-semibold"><?=$data->sum('count') == 0 ? 0 : round(($data->sum('dat')/$data->sum('count'))*100, 2)?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>