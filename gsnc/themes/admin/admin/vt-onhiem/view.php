<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use ttungbmt\map\Map;

/* @var $this yii\web\View */
/* @var $model gsnc\models\VtOnhiem */
/* @var $form yii\widgets\ActiveForm */

$this->title = ' Chi tiết Vị trí ô nhiễm';
?>
<div class="vt-onhiem-form">
    <?php $form = ActiveForm::begin(); ?>
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
                    <?= $form->field($model, 'ten')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'diachi')->textInput(['disabled' => true])  ?>

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
                        'options'       => ['prompt' => 'Chọn phường...', 'disabled' => true],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường') ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'onhiem_id')->dropDownList(['Loại ô nhiễm...'] + api('dm/onhiem'), ['disabled' => true])->label('Loại ô nhiễm') ?>
                </div>
                <div class="col-md-3">

                    <?= $form->field($model, 'ghichu')->textInput(['disabled' => true])   ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
