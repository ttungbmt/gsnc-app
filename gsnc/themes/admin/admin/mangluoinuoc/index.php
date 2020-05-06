<?php

use johnitvn\ajaxcrud\CrudAsset;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\MangluoinuocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);

$this->title = "Mạng lưới nước";
?>
<div class="mangluoinuoc-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id'           => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'pjax'         => true,
            'columns'      => require(__DIR__ . '/_columns.php'),
            'toolbar'      => [
                ['content' =>
                     Html::a('Thêm mới', ['create'],
                         ['title' => 'Thêm mới Mạng lưới nước', 'class' => 'btn btn-primary', 'data-pjax' => 0,]) .
                     Html::a('<i class="icon-reload-alt"></i>', [''],
                         ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                     '{toggleData}' .
                     '{export}'
                ],
            ],
            'striped'      => true,
            'condensed'    => true,
            'responsive'   => true,
            'panel'        => [
                'type'    => 'primary',
                'heading' => '' . lang(' List ') . 'Mạng lưới nước',
            ]
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>





