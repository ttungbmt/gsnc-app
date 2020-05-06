<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use ttungbmt\map\Map;

/* @var $this yii\web\View */
/* @var $model gsnc\models\Mangluoinuoc */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Mạng lưới nước';
?>
<div class="mangluoinuoc-form">

    <div class="card">
        <?=$this->render('_map', [
            'model' => $model
        ])?>

        <?php $form = ActiveForm::begin(); ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'idmaduongo')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'idcapnuoc')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'huongdongc')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'chieudai')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'vatlieu')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'tieuchuan')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'hieu')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'nuocsanxua')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'donhamthuc')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'aplucthiet')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'namlapdat')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'vitrilapda')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'dosau')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'dodoc')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'donhamdanh')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'tinhtrang')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'alhoatdong')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'dktrong')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'dkngoai')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'coong')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'capong')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'loaiongnuo')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'shape_leng')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'shape_le_1')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'objectid')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'id')->textInput() ?>
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
