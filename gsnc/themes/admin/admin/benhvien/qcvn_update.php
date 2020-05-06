<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
    <table class="table table-bordered mb-20">
        <thead>
        <tr>
            <th>STT</th>
            <th>Tên chỉ tiêu</th>
            <th>Giá trị giới hạn</th>
            <th>Kết quả xét nghiệm</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($model as $k => $item) { ?>

            <?php
            $chitieu = $item->chitieu ?? $item;

            $giatri =  $item->chitieu ? $item->giatri : null;

            $status = $item->chitieu ? (($giatri >= $chitieu->val_from & $giatri <= $chitieu->val_to) ? '' : 'danger') : '';
            $limit = function ($from, $to){
                if(!is_null($from) && !is_null($to)){
                    return $from.' - '.$to;
                } elseif (!is_null($from) && is_null($to)){
                    return '&ge; '.$from;
                } elseif (is_null($from) && !is_null($to)){
                    return '&le; '.$to;
                }
                return null;
            };


            ?>
            <tr class="<?= $status ?>">
                <td><?= $k+1 ?></td>
                <td><?= $chitieu->tenchitieu?></td>
                <td><b><?= $limit($chitieu->val_from, $chitieu->val_to)?></b> <span><?= $chitieu->unit ? '('.$chitieu->unit.')' : '' ?></span></td>
                <td>

                    <?= Html::textInput("chitieu[{$item->id}][giatri]", $giatri, ['class' => 'form-control']); ?>

                    <?php

                    ?>


                </td>
            </tr>
        <?php }?>

        </tbody>
    </table>
<?php ActiveForm::end(); ?>