<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\PoiThugomracSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);

$this->title = "Quản lý Điểm thu gom rác";

$partial = app('request')->get('partial') || app('request')->isAjax;
$suffix = '-poithugomrac';
?>
<div class="poi-thugomrac-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'           => 'crud-datatable' . $suffix,
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'pjax'         => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => $pjaxContainer = ('kv-pjax-container' . $suffix),
                ]
            ],
            'columns'      => $gridColumns = require(__DIR__ . '/_columns.php'),
            'toolbar'      => [
                ['content' =>
                     Html::a('Thêm mới', ['create'],
                         ['title' => 'Thêm mới Điểm thu gom rác', 'class' => 'btn btn-default', 'data-pjax' => 0]) .
                     Html::a('<i class="icon-reload-alt"></i>', [''],
                         ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                     '{toggleData}' .
                     '{export}'
                ],
            ],
            'export'       => [
                'fontAwesome'      => true,
                'showConfirmAlert' => false,
                'itemsAfter'       => [
                    '<li role="presentation" class="divider"></li>',
                    '<li class="dropdown-header">Xuất tất cả dữ liệu</li>',
                    ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ]
            ],
            'striped'      => true,
            'condensed'    => true,
            'responsive'   => true,
            'panel'        => [
                'type'    => 'primary',
                'heading' => ' Danh sách Điểm thu gom rác',
            ],
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<?= $this->render('../depdrop_phuong/depdrop_phuong', [
    'selector' => 'PoiThugomracSearch[maphuong]', 'pjaxContainer' => $pjaxContainer
]) ?>





