<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\models\DmOnhiem */
/* @var $form yii\widgets\ActiveForm */
$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Loại ô nhiễm';
?>
<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="dm-onhiem-form">
            <?= $form->field($model, 'maloai')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'mota')->textarea(['rows' => 3]) ?>

            <?php if (!request()->isAjax): ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif; ?>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

