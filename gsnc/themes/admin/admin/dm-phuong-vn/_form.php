<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use ttungbmt\map\Map;

/* @var $this yii\web\View */
/* @var $model gsnc\models\DmPhuongVn */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' dm_phuong_vn';
?>



<?php $form = ActiveForm::begin(); ?>

<div class="dm-phuong-vn-form">

    <div class="card">

        
        <div class="card-body">
                <?= $form->field($model, 'ma')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cap')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ma_quan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_quan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ma_tinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ten_tinh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'danso_2016')->textInput() ?>

    <?= $form->field($model, 'danso_tt')->textInput() ?>

    <?= $form->field($model, 'phuong_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quan_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tinh_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'soho')->textInput() ?>

    <?= $form->field($model, 'mucchitieu')->textInput() ?>

    <?= $form->field($model, 'dientich_tt')->textInput() ?>

    <?= $form->field($model, 'ma_phuong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'geom')->textInput() ?>

    <?= $form->field($model, 'v_geom')->textInput() ?>


            

            <?php if (!request()->isAjax): ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
