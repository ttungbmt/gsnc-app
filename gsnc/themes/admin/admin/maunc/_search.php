<?php

use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\search\MauncSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maunc-search">
    <?php $form = ActiveForm::begin([
        'action'  => ['index'],
        'method'  => 'get',
        'options' => [
            'id'        => 'maunc-form',
            'data-pjax' => 1,
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'qcvn_id')->dropDownList(api('dm/qcvn'), ['prompt' => 'Chọn QCVN...'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'loaimau_id')->dropDownList(api('dm/maunc'), ['prompt' => 'Loại mẫu...'])->label(false) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date_from')->widget(DatePicker::className(), [
                'type'       => DatePicker::TYPE_RANGE,
                'attribute2' => 'date_to',
                'options'    => ['placeholder' => 'Từ ngày lấy mẫu'],
                'options2'   => ['placeholder' => 'Đến ngày']
            ])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'diachi')->textInput(['placeholder' => 'Nhập địa chỉ...'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'maquan')->dropDownList(api('dm/quan'), [
                'id'     => 'maquan1',
                'prompt' => 'Chọn quận...',
            ])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                'options'       => ['prompt' => 'Chọn phường...'],
                'pluginOptions' => [
                    'depends'    => ['maquan1'],
                    'url'        => url(['/api/dm/phuong']),
                    'initialize' => role('quan')
                ],
            ])->label(false) ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Xóa', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>