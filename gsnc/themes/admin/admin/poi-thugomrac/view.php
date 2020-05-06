<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;
use dosamigos\ckeditor\CKEditor;

$this->title = 'Chi tiết Điểm thu gom rác';
?>
<div class="poi-thugomrac-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Map::widget(['model' => $model]) ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'lat')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'lng')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'diachi')->textInput(['disabled' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                        'id'     => 'maquan',
                        'prompt' => 'Chọn quận...',
                        'disabled' => true
                    ])->label('Quận') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options'       => ['prompt' => 'Chọn phường...','disabled' => true],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường')  ?>
                </div>
                
                <div class="col-md-3">
                    <?= $form->field($model, 'sonha')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'tenduong')->textInput(['disabled' => true])?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'ten')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'onhiem_id')->textInput()->dropDownList(['Chọn loại ô nhiễm...'] + api('dm/onhiem'), ['disabled' => true])->label('Loại ô nhiễm') ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
