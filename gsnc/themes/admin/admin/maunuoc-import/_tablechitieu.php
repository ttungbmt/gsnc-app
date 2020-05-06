<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/27/2018
 * Time: 8:55 AM
 */
$i = 0;
?>
<h2><?='Danh sách chỉ tiêu của '.$qcvn?></h2>
<table class="table-bordered" width="100%">
    <tr style="background: #29b6f6; color: #fff;">
        <th width="5%">STT</th>
        <th width="15%">Mã</th>
        <th>Tên chỉ tiêu</th>
    </tr>
    <?php foreach($dschitieu as $ma => $ten) : ?>
        <?php $i++; ?>
        <tr>
            <td><?=$i?></td>
            <td><?=$ma?></td>
            <td><?=$ten?></td>
        </tr>
    <?php endforeach; ?>
</table>
