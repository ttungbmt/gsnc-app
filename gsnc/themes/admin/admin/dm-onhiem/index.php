<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\DmOnhiemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);

$this->title = "Danh mục loại ô nhiễm";
?>
<div class="dm-onhiem-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'           => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'pjax'         => true,
            'columns'      => $gridColumns = require(__DIR__ . '/_columns.php'),
            'toolbar'      => [
                ['content' =>
                     Html::a('Thêm mới', ['create'],
                         ['role' => 'modal-remote', 'title' => 'Thêm mới Dm Onhiems', 'class' => 'btn btn-primary']) .
                     Html::a('<i class="icon-reload-alt"></i>', [''],
                         ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                     '{toggleData}' .
                     ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ],
            ],
            'striped'      => true,
            'condensed'    => true,
            'responsive'   => true,
            'panel'        => [
                'type'    => 'primary',
                'heading' => ' ' . $this->title,
            ]
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>





