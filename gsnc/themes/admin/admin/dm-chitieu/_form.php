<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\models\Dmchitieu */
/* @var $form yii\widgets\ActiveForm */
$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Chỉ tiêu';
?>
<div class="dmchitieu-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <?= $form->field($model, 'qcvn_id')->dropDownList(api('dm/qcvn'), ['prompt' => 'Chọn QCVN...'])->label('QCVN')  ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'ma')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tenchitieu')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'val_from')->textInput() ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'val_to')->textInput() ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>
                </div>

            </div>

            <?php if (!request()->isAjax): ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
