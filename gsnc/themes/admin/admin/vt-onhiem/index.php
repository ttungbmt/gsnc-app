<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\VtOnhiemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);

$this->title = "Danh sách vị trí ô nhiễm";
//$partial = app('request')->get('partial') || app('request')->isAjax || (isset($partial) ? $partial : false);
//$suffix = '-gsnc';
//$tableId = 'crud-datatable' . $suffix;
?>
<div class="vt-onhiem-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
//            'id'           => $tableId,
            'id' => 'crud-datatable',
            'pjaxSettings' => [
                'options' => [
                    'id' => $pjaxContainer = ('kv-pjax-container-gsnc' ),
//                    'enablePushState' => $partial ? false : true,
                ],
            ],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'pjax'         => true,
            'striped'      => true,
            'condensed'    => true,
            'responsive'   => true,
            'columns'      => $gridColumns = require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('Thêm mới', ['create'], ['title' => 'Thêm mới vị trí khảo sát', 'class' => 'btn btn-primary', 'data-pjax' => 0]) .
                    Html::a('<i class="icon-reload-alt"></i>', [''],
                        ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                    '{toggleData}' .
                    ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ],
            ],
            'panel' => [
                'type' => 'primary',
                'heading' => ' Danh sách vị trí ô nhiễm',
            ]

        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<?= $this->render("../depdrop_phuong/depdrop_phuong", [
    "selector" => "VtOnhiemSearch[maphuong]", "pjaxContainer" => $pjaxContainer
]) ?>



