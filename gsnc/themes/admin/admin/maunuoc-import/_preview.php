<?php
use kartik\alert\Alert;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use yii\widgets\LinkPager;
?>
<style>
    #previewForm .card { box-shadow: none; }
    #previewForm table thead { background-color: #eee; }
    .kv-panel-after { padding: 10px }
    .fade:not(.show){opacity: 1 !important;}
</style>

<?=$this->render('_errors', ['models' => $dataProvider->getModels()])?>

<?php if (isset($errors)): ?>
    <?=$this->render('_errors', ['models' => $errors])?>
<?php endif; ?>

<?php if (isset($message)): ?>
    <div class="card-body" style="padding: 10px">
        <?= Alert::widget([
            'options' => ['class' => 'no-border mb-2'],
            'body'    => $message,
        ]) ?>
    </div>
    <script>
        if(window.pages){
            window.pages.push(<?=$page?>)
        } else { window.pages = [<?=$page?>]}
    </script>
<?php endif; ?>


<?php if (request('type') !== 'save-all'): ?>
    <div class="card-flat">
        <?php if (!isset($message)): ?>
            <?php $form = ActiveForm::begin([
                'id' => 'previewForm',
            ]) ?>

            <?= TabularForm::widget([
                'form'              => $form,
                'dataProvider'      => $dataProvider,
                'attributeDefaults' => [
                    'type' => TabularForm::INPUT_TEXT,
                ],
                'serialColumn'      => false,
                'attributes'        => array_first($models)->formAttrs(),
                'checkboxColumn'    => false,
                'actionColumn'      => false,
                'gridSettings'      => [
                    'resizableColumns' => true,
                    'containerOptions' => ['style' => 'height:500px'],
                    'panel'            => [
                        'heading' => '<h3 class="card-title"><i class="icon-droplet2"></i> Danh sách mẫu nước</h3>',
                        'before'  => false,
                        'after'   => false,
                        'footer' => false,
                    ]
                ]
            ]) ?>
            <?php ActiveForm::end() ?>
        <?php endif; ?>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <?= LinkPager::widget([
                        'options'    => ['class' => 'pagination'],
                        'pagination' => $dataProvider->getPagination(),
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?php if (!isset($hideBtnImport) && !isset($message)): ?>
                        <?= Html::a('<span class="ladda-label"><i class="icon-cloud text-size-base position-left"></i> Nhập dữ liệu</span>', '#', ['class' => 'btn bg-blue btn-ladda btn-ladda-spinner pull-right', 'id' => 'btnSubmit', 'data-style' => 'zoom-in']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('.pagination li a').click(function (e) {
                e.preventDefault()

                $(this).html('<i class="fa fa-spinner fa-spin"></i>')
                let data = new FormData($('#uploadForm')[0])
                data.append('pages', _.uniq(window.pages))

                let page = $(e.target).data('page')
                data.append('page', page)
                let url = '/admin/maunuoc-import?type=preview'
                $.ajax({
                    url,
                    type: 'POST',
                    data,
                    processData: false,
                    contentType: false,
                }).done(res => {
                    $('#importResp').html(res.html)
                    window.scrollTo(0, 0);
                })
            })


            $('#btnSubmit').click(function (e) {
                e.preventDefault()
                let l = Ladda.create($('#btnSubmit')[0])
                let url = '/admin/maunuoc-import?type=save'
                let formUpload = new FormData($('#uploadForm')[0])
                formUpload.append('page', <?=$page?>)
                formUpload.append('pages', [])
                let formPreview = new FormData($("#previewForm")[0])
                for (let pair of formPreview.entries()) {
                    formUpload.append(pair[0], pair[1]);
                }


                l.start()
                $.ajax({
                    url,
                    type: 'POST',
                    data: formUpload,
                    processData: false,
                    contentType: false,
                }).done(res => {
                    if (res.status == 'OK') {

                    } else {
                        $('#importResp').html(res.html)
                    }
                    l.stop()
                })
            })

            $('.kv-grid-table').floatThead({
                scrollContainer: function ($table) {
                    return $table.closest('.kv-grid-container');
                }
            })
        })
    </script>
<?php endif; ?>

