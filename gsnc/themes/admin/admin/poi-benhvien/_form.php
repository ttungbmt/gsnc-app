<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\models\PoiBenhvien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poi-benhvien-form">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'ten')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sonha')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tenduong')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'maquan')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'maphuong')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'loaibv')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'dienthoai')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lichlamviec')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'thamkhao')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'gioithieu')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'check')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
