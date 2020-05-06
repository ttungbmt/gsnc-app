<?php
use yii\bootstrap\Html;

$li = function ($name, $url, $icon = '', $rolename = null){
    $active = (app('request')->url == $url) ? 'active' : '';
//    if($rolename && !auth()->can($rolename)){
//        return null;
//    }

    return (
        Html::tag('li', (
        Html::a((
            (empty($icon) ? '' : Html::tag('i', null, ['class' => $icon])) .
            Html::tag('span', $name)
        ), $url, ['class' => 'nav-link '.$active])
        ), ['class' => 'nav-item'])
    );
}
?>

<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <div class="sidebar-content">
        <?= $this->render('@app/views/partials/_sb_user') ?>

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Bảng tin</div> <i class="icon-menu" title="Main"></i></li>
                <?=$li(lang('Dashboard'), '/admin', 'icon-home4')?>
                <li class="nav-item">
                    <a href="/admin/site/changelog" class="nav-link">
                        <i class="icon-list-unordered"></i>
                        <span>Phiên bản</span>
                        <span class="badge bg-blue-400 align-self-center ml-auto">1.0</span>
                    </a>
                </li>
                <?=$li('Liên hệ', '/admin/site/contact', 'icon-phone')?>

                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Quản lý</div> <i class="icon-menu" title="Quản lý"></i></li>
                <?=$li('Mẫu nước', '/admin/maunc', 'icon-droplet2')?>
                <?=$li('Vị trí khảo sát', '/admin/vt-khaosat', 'icon-puzzle2')?>
                <?=$li('Vị trí ô nhiễm', '/admin/vt-onhiem', 'icon-cube2')?>
                <?=$li('Nước thải bệnh viện ', '/admin/benhvien', 'icon-droplet2')?>
                <?=$li('Điểm Thu gom rác ', '/admin/poi-thugomrac', 'icon-trash')?>

                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Công cụ nhập Excel</div> <i class="icon-menu" title="Công cụ nhập Excel"></i></li>
                <?=$li('Nhập Mẫu nước', '/admin/maunuoc-import', 'icon-database-add')?>
                <?=$li('Nhập Vị trí Khảo sát', '/admin/vt-khaosat-import', 'icon-database-add')?>
                <?=$li('Nhập mẫu nước thải BV', '/admin/poi-benhvien-import', 'icon-database-add')?>
                <?=$li('Nhập vị trí ô nhiễm', '/admin/vt-onhiem-import', 'icon-database-add')?>
                <?=$li('Nhập Điểm thu gom rác', '/admin/poi-thugomrac-import', 'icon-database-add')?>

                <?php if (user()->can('admin')): ?>
                    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Danh mục</div> <i class="icon-menu" title="Danh mục""></i></li>
                    <?=$li('QCVN', '/admin/dm-qcvn', 'icon-stack')?>
                    <?=$li('Chỉ tiêu', '/admin/dm-chitieu', 'icon-stack')?>
                    <?=$li('Loại mẫu', '/admin/dm-maunc', 'icon-stack')?>
                    <?=$li('Loại Ô nhiễm', '/admin/dm-onhiem', 'icon-stack')?>
                    <?=$li('Loại Bệnh viện', '/admin/dm-loaibv', 'icon-stack')?>
                    <?=$li('Bệnh viện', '/admin/poi-benhvien', 'icon-stack')?>
                    <?=$li('Quận', '/admin/dm-quan', 'icon-stack')?>
                    <?=$li('Phường', '/admin/dm-phuong', 'icon-stack')?>
                    <?=$li('Phường Việt Nam', '/admin/dm-phuong-vn', 'icon-stack')?>
                <?php endif; ?>

                <?php if (user()->can('admin')): ?>
                    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Thống kê & Báo cáo</div> <i class="icon-menu" title="Thống kê & Báo cáo"></i></li>
                <?=$li('Thống kê', '/admin/thongke', 'icon-statistics')?>
                <?php endif; ?>

                <?php if (user()->can('admin')): ?>
                    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Quản trị hệ thống</div> <i class="icon-menu" title="Quản trị hệ thống"></i></li>
                    <?=$li('Người dùng', '/auth/user', 'icon-user-tie')?>
                    <?=$li('Phân quyền người dùng', '/auth/role', 'icon-people')?>
                    <?=$li('Phân quyền truy cập', '/auth/permission', 'icon-lock')?>
                <?php endif; ?>

                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Khác</div> <i class="icon-menu" title="Khác"></i></li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-history"></i> <span>Lược sử</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Lược sử">
                        <?=$li('Truy cập', '/auth/log-auth')?>
                        <?=$li('Thao tác', '/auth/log-user')?>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-book"></i> <span>Hướng dẫn sử dụng</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Hướng dẫn sử dụng">
                        <?=$li('Tài liệu', '/admin/site/doc-guide')?>
                        <?=$li('Video', '/admin/site/video-guide')?>
                        <?php //echo $li('Video', '/admin/site/video-guide')?>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
</div>