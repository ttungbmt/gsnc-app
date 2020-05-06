<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use ttungbmt\map\Map;

/* @var $this yii\web\View */
/* @var $model gsnc\models\DmPhuong */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Danh mục Quận';
?>



<?php $form = ActiveForm::begin(); ?>

<div class="dm-phuong-form">

    <div class="card">

        
        <div class="card-body">
                <?= $form->field($model, 'caphc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maphuong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maquan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tenphuong')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tenquan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'soho')->textInput() ?>

    <?= $form->field($model, 'geom')->textInput() ?>

    <?= $form->field($model, 'tenphuong_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tenquan_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tenphuong_format')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tenquan_format')->textInput(['maxlength' => true]) ?>


            

            <?php if (!request()->isAjax): ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php endif; ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
