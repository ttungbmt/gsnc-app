<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
    <table class="table table-bordered mb-3">
        <thead>
        <tr>
            <th>STT</th>
            <th>Tên chỉ tiêu</th>
            <th>Giá trị giới hạn</th>
            <th>Kết quả xét nghiệm</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($models as $k => $item): ?>
            <tr class="<?= $item->highlight ?>">
                <td><?= $k+1 ?></td>
                <td><?= $item->tenchitieu?></td>
                <td><?= $item->limit?></td>
                <td>
                    <?= Html::textInput("chitieu[{$item->id}][giatri]", $item->giatri, ['class' => 'form-control']); ?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php ActiveForm::end(); ?>