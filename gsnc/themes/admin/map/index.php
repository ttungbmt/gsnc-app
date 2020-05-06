<?php $this->beginBlock('styles') ?>
<link rel="preload" as="script" href="<?=asset('assets/map/main.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/css/main.css')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/vendor.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/vendor_redux.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/ext_react.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/ext_leaflet.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/ext_app.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/css/ext_app.css')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/ext_other.js')?>">
<link rel="preload" as="script" href="<?=asset('assets/map/manifest.js')?>">

<link href="<?=asset('assets/map/css/main.css')?>" rel="stylesheet">
<link href="<?=asset('assets/map/css/ext_app.css')?>" rel="stylesheet">
<?php $this->endBlock() ?>

<noscript>
    <a href="http://enable-javascript.com/">Javascript must me enabled to use this site.</a>
</noscript>
<react>
    Đang tải...
</react>

<?php $this->beginBlock('scripts') ?>
<script src="<?=url('assets/ba381714/yii.js')?>"></script>
<script src="<?=url('assets/a1606e58/ModalRemote.js')?>"></script>
<script src="<?=url('assets/a1606e58/ajaxcrud.js')?>"></script>
<script src="<?=url('assets/20a58307/js/kv-widgets.js')?>"></script>
<script src="<?=url('assets/caff0410/dist/js/bootstrap-dialog.js')?>"></script>
<script src="<?=url('assets/34f23bb1/js/dialog-yii.js')?>"></script>
<script src="<?=url('assets/1bb870ef/js/kv-grid-export.js')?>"></script>
<script src="<?=url('assets/1bb870ef/js/kv-grid-toggle.js')?>"></script>
<script src="<?=url('assets/ba381714/yii.gridView.js')?>"></script>
<script src="<?=url('assets/ee2657a3/jquery.pjax.js')?>"></script>

<script src="<?=asset('assets/map/manifest.js')?>"></script>
<script src="<?=asset('assets/map/main.js')?>"></script>
<script src="<?=asset('assets/map/vendor.js')?>"></script>
<script src="<?=asset('assets/map/vendor_redux.js')?>"></script>
<script src="<?=asset('assets/map/ext_react.js')?>"></script>
<script src="<?=asset('assets/map/ext_leaflet.js')?>"></script>
<script src="<?=asset('assets/map/ext_app.js')?>"></script>
<script src="<?=asset('assets/map/ext_other.js')?>"></script>

<?php $this->endBlock() ?>
