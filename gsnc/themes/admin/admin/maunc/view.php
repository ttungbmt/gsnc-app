<?php
use kartik\widgets\DatePicker;
use yii\helpers\Url;

use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;

$this->title = ($model->isNewRecord ? '' : 'Chi tiết') . ' Mẫu nước';
$chitieus = $model->getChitieus()->orderBy('chitieu_id')->with('chitieu')->all()
?>
<div class="maunc-form">
    <?php $form = ActiveForm::begin([
        'id' => 'maunuocForm'
    ]); ?>

    <?= Map::widget(['model' => $model]) ?>
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'lat')->textInput(['class' => 'form-control pt-lat', 'disabled' => true])->label('Lat') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'lng')->textInput(['class' => 'form-control pt-lng', 'disabled' => true])->label('Lng') ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'loaimau_id')->dropDownList(['Chọn loại mẫu...'] + api('dm/maunc'), ['disabled' => true])->label('Loại mẫu') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'mamau')->textInput(['disabled' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'diachi')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                        'id'     => 'maquan',
                        'prompt' => 'Chọn quận...',
                        'disabled' => true
                    ])->label('Quận') ?>
                </div>
                <div class="col-md-4">

                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options'       => ['prompt' => 'Chọn phường...', 'disabled' => true],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'ngaylaymau')->textInput()->widget(DatePicker::classname(),
                    ['disabled' => true]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nguoilaymau')->textInput(['disabled' => true]) ?>
                </div>
            </div>

            <!--            Đánh giá         -->
            <h6 class="text-bold">ĐÁNH GIÁ</h6>
            <table class="table table-bordered ">
                <tr>
                    <th>Hóa lý</th>
                    <th>Vi sinh</th>
                    <th>Cả hóa lý và vi sinh</th>
                </tr>
                <tr>
                    <?php
                    $color = function ($value) {
                        return $value == 1 ? 'success' : 'danger';
                    }
                    ?>

                    <td class="<?= $color($model->hl) ?>">
                        <?= $form->field($model, 'hl')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['disabled' => true])->label(false) ?>
                    </td>
                    <td class="<?= $color($model->vs) ?>">
                        <?= $form->field($model, 'vs')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['disabled' => true])->label(false) ?>
                    </td>
                    <td class="<?= $color($model->hl_vs) ?>">
                        <?= $form->field($model, 'hl_vs')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['disabled' => true])->label(false) ?>
                    </td>
                </tr>
            </table>

            <h6 class="text-bold">CHỈ TIÊU KIỂM NGHIỆM</h6>
            <?php if (!empty($chitieus)): ?>

                <?= $this->render('_qcvn', ['models' => $model->getMetaChitieu($model->qcvn_id)]) ?>
            <?php else: ?>
                <div class="form-group">
                    <?= $form->field($model, 'qcvn_id')->dropDownList(['Chọn Quy chuẩn...'] + api('dm/qcvnmc'), ['id'       => 'qcvn', 'class' => 'form-control',
                        'onchange' => '$.post("/admin/maunc/qcvn?id=' . '"+$(this).val(),function(data){$("#tbl-chitieu").html(data);});'
                    ])->label('QCVN') ?>
                </div>
                <div id="tbl-chitieu">

                </div>
            <?php endif; ?>


        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

