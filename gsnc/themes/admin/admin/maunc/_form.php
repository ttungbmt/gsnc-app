<?php

use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ttungbmt\map\Map;
use yii\helpers\ArrayHelper;
use gsnc\models\Maunc;
$this->title = ($model->isNewRecord ? 'Thêm mới' : 'Cập nhật') . ' Mẫu nước';
$chitieus = $model->getChitieus()->orderBy('chitieu_id')->with('chitieu')->all();
?>
<script src="https://unpkg.com/vuejs-datepicker"></script>

<div class="maunc-form">

    <div class="card">
        <div id="vue-app">
        <!--        <input typehl="text" v-model.number="lat">
                    <input type="text" v-model.number="lng">
                    <input type="text" v-model="latlng">-->
            <?php $form = ActiveForm::begin([
                'id' => 'maunuocForm'
            ]); ?>
            <?= Map::widget(['model' => $model]) ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'lat')->textInput(['id' => 'inpLat']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'lng')->textInput(['id' => 'inpLng']) ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field($model, 'loaimau_id')->dropDownList(['Chọn loại mẫu...'] + api('dm/maunc'))->label('Loại mẫu') ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'mamau')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'donvilaymau')->dropDownList(app('api')->get('dm_quan'), [
                            'prompt' => 'Chọn quận...',
                        ])->label('Đơn vị lấy mẫu') ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'maquan')->dropDownList(app('api')->get('dm_quan'), [
                            'id'     => 'maquan',
                            'prompt' => 'Chọn quận...',
                        ])->label('Quận') ?>
                    </div>
                    <div class="col-md-4">

                        <?= $form->field($model, 'maphuong')->widget(DepDrop::className(), [
                            'options'       => ['prompt' => 'Chọn phường...'],
                            'pluginOptions' => [
                                'depends' => ['maquan'],
                                'url'     => url(['/api/dm/phuong']),
                            ],
                        ])->label('Phường') ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'ngaylaymau')->textInput()->widget(DatePicker::classname()); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'nguoilaymau')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <!--            Đánh giá         -->
                <h6 class="font-weight-bold">ĐÁNH GIÁ</h6>
                <table class="table table-bordered ">
                    <tr>
                        <th>Hóa lý</th>
                        <th>Vi sinh</th>
                        <th>Cả hóa lý và vi sinh</th>
                    </tr>
                    <tr>
                        <?php
                        $color = function ($value) {
                            return $value == 1 ? 'success' : 'danger';
                        }
                        ?>

                        <td class="<?= $color($model->hl_xn) ?>">
                            <?= $form->field($model, 'hl_xn')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['v-model' => 'danhgiaHLXN'])->label('Xét nghiệm') ?>
                            <?= $form->field($model, 'hl_mt')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['v-model' => 'danhgiaHLMT'])->label('Môi trường') ?>
                        </td>
                        <td class="<?= $color($model->vs) ?>">
                            <?= $form->field($model, 'vs')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['v-model' => 'danhgiaVS'])->label(false) ?>
                        </td>
                        <td class="<?= $color($model->hl_vs) ?>">
                            <?= $form->field($model, 'hl_vs')->dropDownList([0 => 'Chưa đạt', 1 => 'Đạt'], ['v-model' => 'danhgiaHLVS'])->label(false) ?>
                        </td>
                    </tr>
                </table>

                <h6 class="font-weight-bold mt-3" >CHỈ TIÊU KIỂM NGHIỆM</h6>
                <?php if (!empty($chitieus)): ?>
                    <?php //$this->render('_qcvn', ['models' => $model->getMetaChitieu($model->qcvn_id)]) ?>
                    <list-chitieus :chitieus="qcvn_chitieus" :key="qcvn_chitieus[0].id" v-if="qcvn_chitieus"></list-chitieus>
                <?php else: ?>
                    <div class="form-group">
                        <?= $form->field($model, 'qcvn_id')->dropDownList(api('dm/qcvnmc'), [
                            'id'       => 'qcvn', 'class' => 'form-control',
                            '@change'   => 'changeQcvn',
                            'prompt'   => 'Chọn Quy chuẩn VN...'
                        ])->label('QCVN') ?>
                    </div>
                    <list-chitieus :chitieus="qcvn_chitieus" :key="qcvn_chitieus[0].id" v-if="qcvn_chitieus"></list-chitieus>
                <?php endif; ?>

                <?php if ($model->isNewRecord || role('admin') || (role('quan') && userInfo()->ma_quan == $model->maquan)): ?>
                    <?php if (!request()->isAjax): ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? lang('Create') : lang('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                <?php endif; ?>
                <?php else: ?>
                    <script>
                        $(function () {
                            $('#maunuocForm').find('select, input').each(function (index) {
                                switch ($(this).context.localName) {
                                    case 'input':
                                        $(this).attr('readonly', true)
                                        break;
                                    case 'select':
                                        $(this).attr('disabled', true)
                                        break;
                                    default:
                                }
                            })
                        })
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.3.1/dist/leaflet.css">
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.3.1/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/turf@3.0.14/turf.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.min.css">
<script src="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.min.js"></script>
<link rel="stylesheet" href="/libs/node_modules/vue-maps/dist/static/css/vue-map.css">
<script src="/libs/node_modules/vue-maps/dist/vue-map.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!--<script src="https://unpkg.com/vuex@3.0.1/dist/vuex.js"></script>-->


<script type="text/javascript">
    $(function () {
        let feature = JSON.parse(`<?=json_encode($model->toFeature())?>`);

        var listChitieus = {
            props: ['chitieus'],
            template: `
            <table class="table table-bordered mb-3">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên chỉ tiêu</th>
                    <th>Giá trị giới hạn</th>
                    <th>Kết quả xét nghiệm</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, idx) in chitieus">
                        <td>{{ idx }}</td>
                        <td>{{ item.tenchitieu }}</td>
                        <td v-html="item.limit">{{ item.limit }}</td>
                        <td>
                            <input type="text" :name="'chitieu[' + item.id + '][giatri]'" v-model="item.giatri" class="form-control">
                        </td>
                    </tr>
                </tbody>
            </table>
            `
        };

        var chitieus = <?= json_encode($chitieus) ?>;
        var qcvn_chitieus = null;
        if(chitieus.length !== 0){
            qcvn_chitieus = <?= json_encode(ArrayHelper::toArray($model->getMetaChitieu($model->qcvn_id)))?>;
        }

        var vueApp = new Vue({
            el: '#vue-app',
            name: 'vueApp',
            store: window.store,
            components: {
                'list-chitieus': listChitieus,
            },
            data: {
                mapOpts: {
                    zoom: 15
                },
                qcvn_chitieus: qcvn_chitieus,
            },
            computed: {
                // ...Vuex.mapGetters([
                //     'marker',
                // ])
                danhgiaVS: function(){
                    var _this = this;
                    if(_this.qcvn_chitieus === null) {
                        return 0;
                    }

                    for(var i in _this.qcvn_chitieus){
                        if(_this.qcvn_chitieus[i].danhgia === 'vs') {
                            var val_from = parseFloat(_this.qcvn_chitieus[i].val_from);
                            var val_to = parseFloat(_this.qcvn_chitieus[i].val_to);
                            var giatri = parseFloat(_this.qcvn_chitieus[i].giatri);

                            if(isNaN(giatri) || giatri > val_to || giatri < val_from) {
                                return 0;
                            }
                        }
                    }
                    return 1;
                },
                danhgiaHLXN: function(){
                    var _this = this;
                    if(_this.qcvn_chitieus === null) {
                        return 0;
                    }

                    for(var i in _this.qcvn_chitieus){
                        if(_this.qcvn_chitieus[i].danhgia === 'hl') {
                            var val_from = parseFloat(_this.qcvn_chitieus[i].val_from);
                            var val_to = parseFloat(_this.qcvn_chitieus[i].val_to);
                            var giatri = parseFloat(_this.qcvn_chitieus[i].giatri);

                            if(isNaN(giatri) || (!isNaN(val_from) && giatri < val_from) || (!isNaN(val_to) && giatri > val_to)) {
                                return 0;
                            }
                        }
                    }
                    return 1;
                },
                danhgiaHLMT: function(){
                    var _this = this;
                    if(_this.qcvn_chitieus === null) {
                        return 0;
                    }

                    for(var i in _this.qcvn_chitieus){
                        if(_this.qcvn_chitieus[i].danhgia === 'hl_mt') {
                            var val_from = parseFloat(_this.qcvn_chitieus[i].val_from);
                            var val_to = parseFloat(_this.qcvn_chitieus[i].val_to);
                            var giatri = parseFloat(_this.qcvn_chitieus[i].giatri);

                            if(isNaN(giatri) || (!isNaN(val_from) && giatri < val_from) || (!isNaN(val_to) && giatri > val_to)) {
                                return 0;
                            }
                        }
                    }
                    return 1;
                },
                danhgiaHLVS: function(){
                    var _this = this;
                    if(_this.danhgiaHLXN === 0 || _this.danhgiaHLMT === 0 || _this.danhgiaVS === 0) {
                        return 0;
                    }
                    return 1;
                }
            },
            mounted() {
                // this.$store.commit('ADD_FEATURE', feature)
                // this.$store.commit('@map/SET_ZOOM', 10)
            },
            methods: {
                changeQcvn: function (e) {
                    var _this = this;
                    var qcvnid = e.target.value;
                    $.ajax({
                        url: "/admin/maunc/qcvn?id=" + qcvnid,
                        type: 'POST',
                        success: function(data){
                            _this.qcvn_chitieus = data;
                            _this.$forceUpdate();
                        }
                    });
                }
            }
        });
    })


</script>