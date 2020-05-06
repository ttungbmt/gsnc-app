<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\search\VtOnhiemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vt-onhiem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'ten') ?>

    <?= $form->field($model, 'diachi') ?>

    <?= $form->field($model, 'ghichu') ?>

    <?= $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'onhiem_id') ?>

    <?php // echo $form->field($model, 'maphuong') ?>

    <?php // echo $form->field($model, 'maquan') ?>

    <?php // echo $form->field($model, 'geom') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
