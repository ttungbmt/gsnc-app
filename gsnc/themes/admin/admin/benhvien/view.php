<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;
use dosamigos\ckeditor\CKEditor;
$this->title = ($model->isNewRecord ? '' : 'Chi tiết') . ' Mẫu nước thải bệnh viện';
?>

<div class="benhvien-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Map::widget(['model' => $model]) ?>
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'lat')->textInput(['class' => 'form-control pt-lat'])->input('readOnlyTextInput', ['readOnly' => true])->label('Lat')  ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'lng')->textInput(['class' => 'form-control pt-lng'])->input('readOnlyTextInput', ['readOnly' => true])->label('Lng') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'mamau')->textInput(['maxlength' => true,'readOnly'=> true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'loaimau_id')->dropDownList(['Chọn loại mẫu...'] + api('dm/maunc'),array("disabled" => "disabled"))->label('Loại mẫu') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'ten')->textInput(['maxlength' => true,'readOnly'=> true])->label('Bệnh viện') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'loaibv_id')->dropDownList(['Chọn loại BV...'] + api('dm/loaibv'),array("disabled" => "disabled"))->label('Loại BV') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true,'readOnly'=> true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                        'id'     => 'maquan',
                        'prompt' => 'Chọn quận...',

                    ])->label('Quận') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options'       => ['prompt' => 'Chọn phường...'],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'onhiem_id')->dropDownList(['Chọn loại ô nhiễm...'] + api('dm/onhiem'),array("disabled" => "disabled"))->label('Loại ô nhiễm') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'dienthoai')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'ngaylaymau')->textInput()->widget(DatePicker::classname()); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'gioithieu')->widget(CKEditor::className(), [
                        'preset' => 'full'
                    ]) ?>
                </div>
            </div>

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
                        <?= $form->field($model, 'hl')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'])->label(false) ?>
                    </td>
                    <td class="<?= $color($model->vs) ?>">
                        <?= $form->field($model, 'vs')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'])->label(false) ?>
                    </td>
                    <td class="<?= $color($model->hl_vs) ?>">
                        <?= $form->field($model, 'hl_vs')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'])->label(false) ?>
                    </td>
                </tr>
            </table>

            <h6 class="text-bold">CHỈ TIÊU KIỂM NGHIỆM</h6>

            <?php if (!empty($model->getChitieus()->with('chitieu')->all())): ?>

                <?= $this->render('qcvn_update', ['model' => $model->getChitieus()->with('chitieu')->all()]) ?>
            <?php else: ?>
                <div class="form-group">
                    <?= $form->field($model, 'qcvn_id')->dropDownList(['Chọn Quy chuẩn...'] + api('dm/qcvnbv'),array("disabled" => "disabled"), ['id'       => 'qcvn', 'class' => 'form-control',
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