<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use ttungbmt\map\Map;

/* @var $this yii\web\View */
/* @var $model gsnc\models\PoiThugomrac */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Điểm thu gom rác';
?>

<div class="poi-thugomrac-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= Map::widget(['model' => $model]) ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'lat')->textInput(['id' => 'inpLat']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'lng')->textInput(['id' => 'inpLng']) ?>
                </div>
            </div>


            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'sonha')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'tenduong')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
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
                    ])->label('Phường')  ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'onhiem_id')->textInput()->dropDownList(['Chọn loại ô nhiễm...'] + api('dm/onhiem'))->label('Loại ô nhiễm') ?>
                </div>
            </div>

            <?php if (!request()->isAjax): ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
