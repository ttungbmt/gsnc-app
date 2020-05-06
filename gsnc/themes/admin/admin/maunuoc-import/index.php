<?php
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\alert\Alert;
use yii\helpers\ArrayHelper;
use gsnc\models\DmQcvn;
use kartik\select2\Select2;

$this->title = 'Nhập Excel Mẫu nước';
$qcvn = api('dm/qcvnmc');
$files = \gsnc\models\DmQcvn::pluck('link', 'id');

?>
<style>
    table, th, td {
        padding: 10px;
    }
    tr:nth-child(even) {
        background: #F9F9F9
    }
    tr:nth-child(odd) {
        background: #ffffff;
    }
</style>
<script>
    window.links = <?=json_encode($files)?>
</script>
<div class="card card-white">
    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'uploadForm', 'enctype' => 'multipart/form-data'],
//        'type' => ActiveForm::TYPE_INLINE,
    ]);?>
    <div class="card-header header-elements-inline">
        <div class="card-title font-weight-semibold text-uppercase">
            <i class="icon-database-add text-size-base position-left"></i>
            Nhập dữ liệu
        </div>
        <div class="heading-elements">
            <?= Html::a('<i class="icon-file-download"></i> Tải file mẫu', $files[1],['id' => 'btn-download', 'class' => 'btn btn-link']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?= Select2::widget([
                    'data' => $qcvn,
                    'name' => 'qcvn',
                    'options'=> [
                        'onchange' => '$.post("/admin/maunuoc-import/dschitieu?id=' . '"+$(this).val(),(data) => {
                            $("#table-qcvn").html(data);
                            $("#btn-download").attr("href", window.links[$(this).val()])
                        });'
                    ],
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
            </div>
            <div class="col-md-4">
                <div class="btn-group pull-right">
                    <?= Html::submitButton('<span class="ladda-label"> <i class="icon-cloud-upload"></i> Xem trước</span>', ['id' => 'btnPreview', 'name' => 'btnPreview', 'class' => 'btn btn-success btn-ladda btn-ladda-spinner', 'data-style' => 'zoom-in']) ?>
                    <?= Html::button('<span class="ladda-label"><i class="icon-database-insert"></i> Nhập tất cả</span>', ['id' => 'btnSaveAll', 'class' => 'btn btn-primary btn-ladda btn-ladda-spinner', 'data-style' => 'zoom-in']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end() ?>

    <div id="importResp" style="overflow: hidden">

    </div>

</div>

<div class="alert" style="border: 1px solid rgba(0, 188, 212, 0.52); background-color: white;">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    <h6 class="alert-heading font-weight-semibold"><span class="badge bg-blue-400">1 </span>  Hướng dẫn</h6>
    <p> - Chọn Quy chuẩn tại menu thả xuống bên trái</p>
    <p> - Nhấn nút "TẢI FILE MẪU" để tải file excel mẫu về máy</p>
    <p> - Nhấn nút "CHOOSE FILE" để chọn file excel nhập dữ liệu</p>
    <p> - Nhấn nút "XEM TRƯỚC" để hiển thị giao diện xem và chỉnh sửa dữ liệu file excel</p>
    <p> - Nhấn nút "NHẬP DỮ LIỆU" để nhập dữ liệu trên trang hiện tại vào cơ sở dữ liệu</p>
    <p> - Nhấn nút "NHẬP TẤT CẢ" để nhập toàn bộ dữ liệu từ file excel vào cơ sở dữ liệu</p>
    <br>

    <h6 class="alert-heading font-weight-semibold"><span class="badge bg-blue-400">2 </span>  Format file excel mẫu</h6>
    <p> - Các cột bắt buộc phải có (Tên - mã): </p>
        <p style="margin-left: 2em">+ Quận/huyện - <b>maquan</b></p>
        <p style="margin-left: 2em">+ Phường/xã - <b>maphuong</b></p>
        <p style="margin-left: 2em">+ Địa chỉ lấy mẫu - <b>diachi</b></p>
        <p style="margin-left: 2em">+ Loại mẫu - <b>loaimau_id</b></p>
        <p style="margin-left: 2em">+ Ngày lấy mẫu - <b>ngaynhanmau</b></p>
        <p style="margin-left: 2em">+ Mã mẫu - <b>mamau</b></p>
        <p style="margin-left: 2em">+ VS - <b>vs</b></p>
        <p style="margin-left: 2em">+ HL (XN) - <b>hl_xn</b></p>
        <p style="margin-left: 2em">+ HL (MT) - <b>hl_mt</b></p>
        <p style="margin-left: 2em">+ VS & HL - <b>hl_vs</b></p>
        <p style="margin-left: 2em">+ Lat - <b>lat</b></p>
        <p style="margin-left: 2em">+ Lng - <b>lng</b></p>

    <p> - Tên Quận/Huyện, Phường/Xã: </p>
        <p style="margin-left: 2em"> + Tên Quận/Huyện, Phường/Xã theo tiếng anh </p>
        <p style="margin-left: 2em"> + Tên Quận là số: 01, 02, ... 12</p>
        <p style="margin-left: 2em"> + Tên Quận/Huyện là chữ: THU DUC , BINH CHANH, ...</p>
        <p style="margin-left: 2em"> + Tên Phường/Xã là số: 01, 02,...</p>
        <p style="margin-left: 2em"> + Tên Phường/Xã là chữ: TAN THONG HOI, PHUOC HIEP,</p>
    <p> - Loại mẫu phải thuộc <a href="/admin/dm-maunc" target="_blank">danh sách</a></p>
    <p> - Dòng mã bắt buộc là dòng thứ 4 và dữ liệu bắt đầu từ dòng thứ 5</p>

    <p> - Vui lòng kiểm tra lại để đảm bảo tên chỉ tiêu trùng với mã theo bảng dưới đây:</p>
    <br>
    <div id="table-qcvn">
        <h2>Danh sách chỉ tiêu của QCVN 01:2009/BYT</h2>
        <table class="table-bordered" width="100%">
            <tr style="background: #29b6f6; color: #fff;">
                <th width="5%">STT</th>
                <th width="15%">Mã</th>
                <th>Tên chỉ tiêu</th>
            </tr>
           <!-- <?php /*foreach($dm_chitieu as $ma => $ten) : */?>
                <tr>
                    <td><?/*=!isset($stt) ? $stt = 1 : ++$stt*/?></td>
                    <td><?/*=$ma*/?></td>
                    <td><?/*=$ten*/?></td>
                </tr>
            --><?php /*endforeach; */?>
        </table>
    </div>
</div>

<?php $this->beginBlock('scripts') ?>
    <script src="<?=url('/libs/bower/jquery.floatThead/dist/jquery.floatThead.min.js')?>"></script>
    <script>
        $(function () {
            const postApi = (url, data) => {
                return $.ajax({
                    url,
                    type: 'POST',
                    data,
                    processData: false,
                    contentType: false,
                })
            }

            $('#uploadForm').submit(function (e) {

                document.cookie = "refesh=true";
                e.preventDefault()
                window.pages = []

                let data = new FormData(this)
                let l = Ladda.create($('#btnPreview')[0])
                l.start()
                const api = postApi(`/admin/maunuoc-import?type=preview`, data)
                api.done(res => {
                    l.stop()
                    $('#importResp').html(res.html)
                }).fail(() => l.stop())
            })

            $('#btnSaveAll').click(function (e) {
                window.pages = []

                e.preventDefault()
                let l = Ladda.create($(this)[0])
                let data = new FormData($('#uploadForm')[0])
                const api = postApi(`/admin/maunuoc-import?type=save-all`, data)
                l.start()
                api.done(res => {
                    l.stop()
                    $('#importResp').html(res.html)
                }).fail(() => l.stop())
            })

        })
    </script>
<?php $this->endBlock() ?>