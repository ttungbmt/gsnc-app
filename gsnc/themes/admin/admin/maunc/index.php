<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\MauncSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);
$this->title = "Danh sách Mẫu nước";
$partial = app('request')->get('partial') || app('request')->isAjax;
$suffix = '-maunc';
?>
<div class="maunc-index">
    <div id="ajaxCrudDatatable">
        <?=$this->render('_search', ['model' => $searchModel])?>
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax' => true,
            'pjaxSettings'     => [
                'options' => [
//                    'id' => $pjaxContainer = ('kv-pjax-container'. $suffix ),
                    'formSelector' => '#maunc-form, #crud-datatable-pjax form[data-pjax]'
                ],
            ],
            'columns' => $gridColumns = require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('Thêm mới', ['create'], ['title' => 'Thêm mới Mẫu nước', 'class' => 'btn btn-primary', 'data-pjax' => 0]) .
                    Html::a('<i class="icon-reload-alt"></i>', [''],
                        ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                    '{toggleData}' .
                    ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => ' Danh sách Mẫu nước',
            ]
        ]) ?>
    </div>

</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>




