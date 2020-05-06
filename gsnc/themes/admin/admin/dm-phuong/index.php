<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 

/* @var $this yii\web\View */
/* @var $searchModel gsnc\search\DmPhuongSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
CrudAsset::register($this);

$this->title = "Danh mục Quận";
?>
<div class="dm-phuong-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
                    'id'=> 'crud-datatable',
                    'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[name="pagination"]',
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('Thêm mới', ['create'],
                    ['role'=>'modal-remote','title'=> 'Thêm mới Danh mục Quận','class'=>'btn btn-default', ]).
                    Html::a('<i class="icon-reload-alt"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=> lang('Reset Grid')]).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => 'Danh sách Danh mục Quận',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=> "ajaxCrudModal",
    "footer"=> "",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>





