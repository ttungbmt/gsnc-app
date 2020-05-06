<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\DmchitieuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CrudAsset::register($this);
$this->title = "Danh sách chỉ tiêu";
?>
<div class="dmchitieu-index">

    <div id="ajaxCrudDatatable">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => 'crud-datatable',
            'pjax' => true,
            'columns' => $gridColumns = require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('Thêm mới', ['create'], ['title' => 'Thêm mới chỉ tiêu', 'class' => 'btn btn-primary']) .
                    Html::a('<i class="icon-reload-alt"></i>', [''],
                        ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                    '{toggleData}' .
                    ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ],
            ],
            'panel' => [
                'type' => 'primary',
                'heading' => ' Danh sách chỉ tiêu',
            ]
        ]); ?>
    </div>
</div>
