<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\BenhvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CrudAsset::register($this);
$this->title = "Danh sách Mẫu nước thải bệnh viện";

$partial = app('request')->get('partial') || app('request')->isAjax;
$suffix = '-benhvien';
?>
<div class="benhvien-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'           => 'crud-datatable-pjax',
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
                     Html::a('Thêm mới', ['create'], ['title' => 'Thêm mới Mẫu nước thải bệnh viện', 'class' => 'btn btn-primary', 'data-pjax' => 0]) .
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
                'heading' => ' Danh sách Mẫu nước thải bệnh viện',
            ]
        ]); ?>
    </div>
</div>

<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<?= $this->render('../depdrop_phuong/depdrop_phuong', [
    'selector' => 'BenhvienSearch[maphuong]', 'pjaxContainer' => $pjaxContainer
]) ?>
