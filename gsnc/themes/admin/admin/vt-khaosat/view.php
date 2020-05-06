<?php
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;
use gsnc\models\MetaYkien;
use gsnc\models\VtKsYkien;
use gsnc\models\VtKhaosat;

/* @var $this yii\web\View */
/* @var $model gsnc\models\VtKhaosat */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Chi tiết Vị trí khảo sát';

$dm = api('dm/group-ykien');
$dm_ykien = $model->getMetaYkien();

foreach($dm as $id => $name){
    $group_ykien[$id] = [];
    foreach ($dm_ykien as $yk) {
        if($yk['group_id'] == $id) {
            array_push($group_ykien[$id], $yk);
        }
    }
}

if(!$model->isNewRecord){
    $ykiens = collect($model->getYkiens()->with('meta')->all())->map(function ($item, $k) {
        return [
            'model' => $item,
            'group_id' => data_get($item, 'meta.group_id'),
            'ten' => data_get($item, 'meta.ten')
        ];
    })->groupBy('group_id')->all();
} else {
    $ykiens = collect(MetaYkien::find()->all())->map(function ($item, $k) {
        return [
            'model' => new VtKsYkien(),
            'group_id' => data_get($item, 'group_id'),
            'ten' => data_get($item, 'ten'),
            'id' => data_get($item, 'id'),
        ];
    })->groupBy('group_id')->all();
}
?>

<div class="vt-khaosat-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= Map::widget(['model' => $model]) ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'lat')->textInput(['class' => 'form-control pt-lat', 'disabled' => true])->label('Lat') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'lng')->textInput(['class' => 'form-control pt-lng', 'disabled' => true])->label('Lng') ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'tenchuho')->textInput(['disabled' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'ngaykhaosat')->widget(DatePicker::classname(),[
                        'disabled' => true] ); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'diachi')->textInput(['disabled' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                        'id'     => 'maquan',
                        'prompt' => 'Chọn quận...',
                        'disabled' => true
                    ])->label('Quận') ?>
                </div>
                <div class="col-md-4">

                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options'       => ['prompt' => 'Chọn phường...', 'disabled' => true],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường') ?>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>Ý kiến/ Khảo sát</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($group_ykien as $key => $yk) : ?>
                    <?php foreach ($yk as $i => $item) : ?>
                        <tr>
                            <?php if($i == 0) : ?>
                                <td rowspan="<?= count($yk) ?>"><?=data_get($dm, $key)?></td>
                            <?php endif; ?>
                            <td class="<?= $item['highlight']?>"><?=$item['ten']?></td>
                            <td class="<?= $item['highlight']?>"><?= Html::textInput("VtKsYkien[{$item['id']}][value]", $item['value'], ['class' => 'form-control', 'disabled' => true]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
