<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\export\ExportMenu;

CrudAsset::register($this);
$this->title = "Danh sách vị trí khảo sát";
?>
<div class="vt-khaosat-index">
    <div id="ajaxCrudDatatable">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
        <?= GridView::widget([
            'id'           => 'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax'         => true,
            'pjaxSettings' => [
                'options' => [
                    'formSelector' => '#vt-khaosat-form, #crud-datatable-pjax form[data-pjax]'
                ]
            ],

            'columns' => $gridColumns = require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                     Html::a('Thêm mới', ['create'], ['title' => 'Thêm mới vị trí khảo sát', 'class' => 'btn btn-primary', 'data-pjax' => 0]) .
                     Html::a('<i class="icon-reload-alt"></i>', [''],
                         ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => lang('Reset Grid')]) .
                     '{toggleData}' .
                     ExportMenu::widget(['dataProvider' => $dataProvider, 'columns' => $gridColumns])
                ],
            ],
            'panel'   => [
                'type'    => 'primary',
                'heading' => ' Danh sách vị trí khảo sát',
            ]
        ]); ?>

    </div>
</div>
<?php Modal::begin([
    "id"     => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

