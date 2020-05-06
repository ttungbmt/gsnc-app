<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\export\ExportMenu;
$this->title = "Danh mục Loại mẫu";

CrudAsset::register($this);
?>
<div class="dm-maunc-index">
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
                         ['role' => 'modal-remote', 'title' => 'Thêm mới loại mẫu', 'class' => 'btn btn-default']) .
                     Html::a('<i class="icon-reload-alt"></i>', [''],
                         ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => trans('app', 'Reset Grid')]) .
                     '{toggleData}' .
                     ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ],
            ],
//            'striped' => true,
//            'condensed' => true,
//            'responsive' => true,
            'panel'        => [
                'type'    => 'primary',
                'heading' => ' Danh mục loại mẫu',
            ]
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
