<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;
use dosamigos\ckeditor\CKEditor;
$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Mẫu nước thải bệnh viện';
//$chitieus = $model->getChitieus()->orderBy('benhvien_id')->with('chitieu')->all();
$chitieus = $model->getChitieus()->with('chitieu')->all();
$maquan = $model->maquan;
$maphuong = $model->maphuong;
?>

<div class="benhvien-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'mamau')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'loaimau_id')->dropDownList(['Chọn loại mẫu...'] + api('dm/maunc'))->label('Loại mẫu') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'ten')->textInput(['maxlength' => true])->label('Bệnh viện') ?>
                </div>
                <div class="col-md-3">
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
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
                            'initialize'   => $maquan == true,
                            'placeholder'  => 'Chọn phường...',
                            'ajaxSettings' => ['data' => ['value' => $maphuong]],
                        ],
                    ])->label('Phường') ?>
                </div>
                <div class="col-md-3">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'ngaylaymau')->textInput()->widget(DatePicker::classname()); ?>
                </div>
            </div>
               <h6 class="font-weight-bold">ĐÁNH GIÁ</h6>
            <table class="table table-bordered ">
                <tr>
                    <th>Hóa lý</th>
                    <th>Vi sinh</th>
                    <th>Cả hóa lý và vi sinh</th>
                </tr>
                <tr>
                    <?php $color = function ($value) {return $value == 1 ? 'success' : 'danger';} ?>
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

            <h6 class="font-weight-bold mt-3">CHỈ TIÊU KIỂM NGHIỆM</h6>

            <?php if (!empty($chitieus)): ?>
                <?= $this->render('_qcvn', ['models' => $model->getMetaChitieu($model->qcvn_id)]) ?>
            <?php else: ?>
                <div class="form-group">
                    <?= $form->field($model, 'qcvn_id')->dropDownList(['Chọn Quy chuẩn...'] + api('dm/qcvnbv'), ['id'       => 'qcvn', 'class' => 'form-control',
                                                                                                                 'onchange' => '$.post("/admin/maunc/qcvn?id=' . '"+$(this).val(),function(data){$("#tbl-chitieu").html(data);});'
                    ])->label('QCVN') ?>
                </div>
                <div id="tbl-chitieu" class="mb-3">

                </div>
            <?php endif; ?>

            <?php if (!request()->isAjax): ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>