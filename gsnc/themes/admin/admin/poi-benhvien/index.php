<?php
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel gsnc\models\search\PoiBenhvienBenhvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bệnh viện';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poi-benhvien-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="text-right">
        <?= Html::a('Thêm mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns = require(__DIR__ . '/_columns.php'),
        'panel' => [
            'type' => 'primary',
            'heading' => ' Danh sách Bệnh viện',
        ]
       ]); ?>
</div>
