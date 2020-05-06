<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gsnc\models\DmQcvn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="dm-qcvn-form">

            <?= $form->field($model, 'tenqc')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'ghichu')->textarea(['rows' => 6]) ?>

            <?php if (!request()->isAjax): ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif; ?>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

