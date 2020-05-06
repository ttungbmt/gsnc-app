<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;
use gsnc\models\MetaYkien;
use gsnc\models\VtKsYkien;
use gsnc\models\VtKhaosat;

/* @var $this yii\web\View */
/* @var $model gsnc\models\VtKhaosat */
/* @var $form yii\widgets\ActiveForm */
$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Vị trí khảo sát';

$dm = api('dm/group-ykien');
$dm_ykien = $model->getMetaYkien();

foreach ($dm as $id => $name) {
    $group_ykien[$id] = [];
    foreach ($dm_ykien as $yk) {
        if ($yk['group_id'] == $id) {
            array_push($group_ykien[$id], $yk);
        }
    }
}

if (!$model->isNewRecord) {
    $ykiens = collect($model->getYkiens()->with('meta')->all())->map(function ($item, $k) {
        return [
            'model'    => $item,
            'group_id' => data_get($item, 'meta.group_id'),
            'ten'      => data_get($item, 'meta.ten')
        ];
    })->groupBy('group_id')->all();
} else {
    $ykiens = collect(MetaYkien::find()->all())->map(function ($item, $k) {
        return [
            'model'    => new VtKsYkien(),
            'group_id' => data_get($item, 'group_id'),
            'ten'      => data_get($item, 'ten'),
            'id'       => data_get($item, 'id'),
        ];
    })->groupBy('group_id')->all();
}
?>

<div class="vt-khaosat-form">

    <?php $form = ActiveForm::begin([
        'id' => 'vtKhaosatForm'
    ]); ?>
    <?= Map::widget(['model' => $model]) ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'lat')->textInput(['id' => 'inpLat']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'lng')->textInput(['id' => 'inpLng']) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'tenchuho')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'ngaykhaosat')->textInput()->widget(DatePicker::classname()); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                        'id'     => 'maquan',
                        'prompt' => 'Chọn quận...',
                    ])->label('Quận') ?>
                </div>
                <div class="col-md-4">

                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options'       => ['prompt' => 'Chọn phường...'],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường') ?>
                </div>
            </div>

            <table class="table mb-3">
                <thead>
                <tr>
                    <th>Ý kiến/ Khảo sát</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($group_ykien as $key => $yk) : ?>
                    <?php foreach ($yk as $i => $item) : ?>
                        <tr>
                            <?php if ($i == 0) : ?>
                                <td rowspan="<?= count($yk) ?>"><?= data_get($dm, $key) ?></td>
                            <?php endif; ?>
                            <td class="<?= $item['highlight'] ?>"><?= $item['ten'] ?></td>
                            <td class="<?= $item['highlight'] ?>"><?= Html::textInput("VtKsYkien[{$item['id']}][giatri]", $item['giatri'], ['class' => 'form-control']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($model->isNewRecord || role('admin') || (role('quan') && userInfo()->ma_quan == $model->maquan)): ?>
                <?php if (!request()->isAjax): ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif; ?>
            <?php else: ?>
                <script>
                    $(function () {
                        $('#vtKhaosatForm').find('select, input').each(function (index) {
                            switch ($(this).context.localName) {
                                case 'input':
                                    $(this).attr('readonly', true)
                                    break;
                                case 'select':
                                    $(this).attr('disabled', true)
                                    break;
                                default:
                            }
                        })
                    })
                </script>
            <?php endif; ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
