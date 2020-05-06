<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\models\Dmloaibv */
/* @var $form yii\widgets\ActiveForm */
$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Loại bệnh viện';
?>

<div class="dmloaibv-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'maloai')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'mota')->textInput(['maxlength' => true])  ?>
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
