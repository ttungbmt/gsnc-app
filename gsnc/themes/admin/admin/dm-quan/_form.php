<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use ttungbmt\map\Map;

/* @var $this yii\web\View */
/* @var $model gsnc\models\DmQuan */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Danh mục Quận';
?>



<?php $form = ActiveForm::begin(); ?>

<div class="dm-quan-form">

    <div class="card">
        <div class="card-body">
            <?= $form->field($model, 'tenquan')->textInput() ?>

            <?= $form->field($model, 'maquan')->textInput() ?>

            <?php if (!request()->isAjax): ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? lang('Thêm mới') : lang('Cập nhật'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
