<?php
use gsnc\models\Benhvien;
use gsnc\models\Maunc;
use gsnc\models\VtKhaosat;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;

$this->title = 'Thống kê';
$dm_quan = api('dm/quan');
$dm_qcvn = api('dm/qcvn');
$dm_maunc = api('dm/maunc');
$dm_bv = api('dm/benhvien');
$dm_loaibv = api('dm/loaibv');

$dm_entity_type = [
    Maunc::className()     => 'Mẫu nước',
    VtKhaosat::className() => 'Vị trí khảo sát',
    Benhvien::className()  => 'Nước thải bệnh viện'
];
$attr = [
    'entity_type' => $model->entity_type,
];
?>

<div id="vueStat" class="thongke-form">
    <?php $form = ActiveForm::begin([
        'id'      => 'tk-form',
        'options' => [
//            'v-on:submit.prevent' => 'onSubmit',
        ]
    ]); ?>
    <div class="card card-white border-left-lg border-left-info">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">
                <span class="font-weight-semibold"><i class="icon-statistics position-left"></i> Thống kê</span>
            </h6>
            <div class="heading-elements">
                <?= Html::submitButton('<i class="icon-graph"></i> Thống kê', ['class' => 'btn btn-info btn-labeled btn-rounded']) ?>
                <?= Html::button('<i class="icon-graph"></i> Xuất báo cáo', ['v-if' => "inner !=''", '@click' => 'handleExport', 'class' => 'btn btn-success btn-labeled btn-rounded']) ?>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'entity_type')->radioList($dm_entity_type, ['itemOptions' => ['v-model' => 'entity_type']]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'loai_bc')->radioList([1 => 'Chung', 2 => 'Chỉ tiêu']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'donvilaymau')->dropDownList($dm_quan, [
                        'id'     => 'donvilaymau',
                        'prompt' => 'Chọn đơn vị...',
                    ])->label('Đơn vị lấy mẫu') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'maquan')->dropDownList($dm_quan, [
                        'id'     => 'maquan',
                        'prompt' => 'Chọn quận...',
                    ])->label('Quận') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                        'options'       => ['prompt' => 'Chọn phường...'],
                        'pluginOptions' => [
                            'depends' => ['maquan'],
                            'url'     => url(['/api/dm/phuong']),
                        ],
                    ])->label('Phường') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'date_from')->widget(DatePicker::className(), [
                        'type'       => DatePicker::TYPE_RANGE,
                        'attribute2' => 'date_to',
                        'options'    => ['placeholder' => 'Từ ngày'],
                        'options2'   => ['placeholder' => 'Đến ngày']
                    ])->label('Ngày lấy mẫu') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'qcvn_id')->dropDownList($dm_qcvn, ['prompt' => 'Tất cả'])->label('QCVN') ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'loaimau_id')->dropDownList($dm_maunc, ['prompt' => 'Tất cả'])->label('Loại mẫu') ?>
                </div>
                <div class="col-md-6">
                    <div class="row" v-if="entity_type == 'gsnc\\models\\Benhvien'">
                        <div class="col-md-6">
                            <?= $form->field($model, 'loai_bv')->dropDownList($dm_loaibv, ['prompt' => 'Tất cả']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'bv_id')->dropDownList($dm_bv, ['prompt' => 'Tất cả']) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div id="resp-html" v-html="inner">

    </div>
</div>

<?php $this->beginBlock('beforeScripts'); ?>
<script>
    $(function () {
        let progress = `<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"> <span class="sr-only">50% Complete</span> </div></div>`
        let app = new Vue({
            el: '#vueStat',
            data: {
                inner: '',
                ...<?=json_encode($attr)?>
            },
            mounted() {
                $(document).on("beforeSubmit", "#tk-form",  () => {
                    this.inner = progress
                    $.post('/admin/thongke', $('#tk-form').serialize()).then(html => {
                        this.inner = html
                    }).catch(() => this.inner = '')

                    return false;
                });
            },
            methods:{
                handleExport(){
                    $('#tbStat').tableExport({type: 'excel'})
                }
            }
        })
    })
</script>
<?php $this->endBlock(); ?>



