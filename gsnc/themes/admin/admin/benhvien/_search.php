<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\search\BenhvienSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="benhvien-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gid') ?>

    <?= $form->field($model, 'ten') ?>

    <?= $form->field($model, 'diachi') ?>

    <?= $form->field($model, 'sonha') ?>

    <?= $form->field($model, 'tenduong') ?>

    <?php // echo $form->field($model, 'tenquan') ?>

    <?php // echo $form->field($model, 'maquan') ?>

    <?php // echo $form->field($model, 'maphuong') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'loaibv') ?>

    <?php // echo $form->field($model, 'dienthoai') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'lichlamviec') ?>

    <?php // echo $form->field($model, 'thamkhao') ?>

    <?php // echo $form->field($model, 'gioithieu') ?>

    <?php // echo $form->field($model, 'check') ?>

    <?php // echo $form->field($model, 'onhiem_id') ?>

    <?php // echo $form->field($model, 'geom') ?>

    <?php // echo $form->field($model, 'loaibv_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'vs') ?>

    <?php // echo $form->field($model, 'hl') ?>

    <?php // echo $form->field($model, 'hl_vs') ?>

    <?php // echo $form->field($model, 'qcvn_id') ?>

    <?php // echo $form->field($model, 'ngaylaymau') ?>

    <?php // echo $form->field($model, 'mamau') ?>

    <?php // echo $form->field($model, 'loaimau_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
