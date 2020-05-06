<?php

use ttungbmt\amcharts\AmCharts;
use kartik\daterange\DateRangePicker;

$this->title = 'Trang chủ';
?>
<style type="text/css">
    .amcharts-chart-div > a {
        display: none !important;
    }

    .daterangepicker .ranges {display: none}
</style>


<div class="system-statistic row">
    <div class="col-md-3">
        <div class="card card-body bg-success-400 has-bg-image">
            <div class="media no-margin">
                <div class="media-body">
                    <h3 class="no-margin"><?= isset($vtkhaosats) ? $vtkhaosats[0] : "0"; ?></h3>
                    <span class="text-uppercase text-size-mini">Vị trí Khảo sát</span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-brain icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body bg-danger-400 has-bg-image">
            <div class="media no-margin">
                <div class="media-body">
                    <h3 class="no-margin"><?= isset($vtonhiems) ? $vtonhiems[0] : "0"; ?></h3>
                    <span class="text-uppercase text-size-mini">Vị trí Ô nhiễm</span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-cart4 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body bg-pink-400 has-bg-image">
            <div class="media no-margin">
                <div class="media-body">
                    <h3 class="no-margin"><?= isset($maunuocs) ? $maunuocs[0] : "0"; ?></h3>
                    <span class="text-uppercase text-size-mini">Mẫu nước</span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-office icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body bg-indigo-400 has-bg-image">
            <div class="media no-margin">
                <div class="media-body">
                    <h3 class="no-margin"><?= isset($users) ? $users[0] : "0"; ?></h3>
                    <span class="text-uppercase text-size-mini">Người dùng</span>
                </div>
                <div class="media-right media-middle">
                    <i class="icon-user-tie icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-9">
        <div class="m-2">
            <form id="frm-date">
                <?= DateRangePicker::widget([
                    'name'           => 'date_range',
                    'value' => request('date_range', ''),
                    'convertFormat'  => true,
                    'startAttribute' => 'from_date',
                    'endAttribute'   => 'to_date',
                    'options'        => [
                        'placeholder' => 'Nhập thời gian',
                        'class'       => 'form-control'

                    ],
                    'pluginOptions'  => [
                        'locale' => ['format' => 'd/m/Y'],
                    ],
                    'pluginEvents'   => [
                        "apply.daterangepicker" => "function() { $('#frm-date').submit() }",
                    ]
                ]) ?>
            </form>

        </div>


        <div class="card card-white">
            <div class="card-header">
                <h6 class="font-weight-semibold card-title">
                    <i class="icon-cube position-left"></i>
                    Thống kê số lượng mẫu nước đạt
                </h6>
            </div>
            <?php
            if (!isset($dataProvider)) {
                $dataProvider = [
                    [
                        'loai_nuoc' => 'Mẫu nước',
                        'dat'       => 5,
                        'khongdat'  => 4,
                    ]
                ];
            } ?>

            <?= AmCharts::widget([
                'valueAxes'            => [
                    [
                        'title' => 'Số lượng'
                    ]
                ],
                'defaultPluginOptions' => [
                    "title"         => "",
                    "categoryField" => "loai_nuoc",
                    "angle"         => 25,
                    "depth3D"       => 25,
                    "legend"        => [
                        "enabled"          => true,
                        "useGraphSettings" => true
                    ],
                    "trendLines"    => [],
                    "graphs"        => [
                        [
                            'type'        => 'column',
                            'valueField'  => 'dat',
                            'fillAlphas'  => 1,
                            'title'       => 'Đạt',
                            'balloonText' => '[[loai_nuoc]] [[title]]: [[value]]',
                            'columnWidth' => 0.5,
                            'labelText'   => '[[value]]'
                        ],
                        [
                            'type'        => 'column',
                            'valueField'  => 'khongdat',
                            'fillAlphas'  => 1,
                            'title'       => 'Không đạt',
                            'balloonText' => '[[loai_nuoc]] [[title]]: [[value]]',
                            'columnWidth' => 0.5,
                            'labelText'   => '[[value]]'
                        ]
                    ],
                    'dataProvider'  => $dataProvider
                ]
            ]) ?>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card card-white">
                    <?= $this->render('_somau_col') ?>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card card-white">
                    <?= $this->render('_somau_pie') ?>
                </div>
            </div>
        </div>

        <!-- Mô tả hệ thống -->
        <div class="system-description row" style="margin-top: 50px;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-puzzle2 text-green-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/admin/vt-khaosat"
                                                                                      class="text-default">Vị trí khảo
                                            sát</a></h6>
                                    Quản lý thông tin các vị trí khảo sát ý kiến từ người dân
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-cube2 text-danger-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/admin/vt-onhiem"
                                                                                      class="text-default">Vị trí ô
                                            nhiễm</a></h6>
                                    Quản lý thông tin các vị trí gây ô nhiễm nguồn nước
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-droplet2 text-pink-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/admin/maunc"
                                                                                      class="text-default">Mẫu nước</a>
                                    </h6>
                                    Quản lý thông tin về các chỉ tiêu của các mẫu nước thu thập được
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-droplet2 text-blue-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/admin/benhvien"
                                                                                      class="text-default">Nước thải
                                            bệnh viện</a></h6>
                                    Quản lý thông tin về các chỉ tiêu của các mẫu nước thải tại bệnh viện
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-stack text-indigo-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold">Danh mục</h6>
                                    <span>Danh sách các </span>
                                    <a href="/admin/dm-qcvn">Quy chuẩn</a>,
                                    <a href="/admin/dm-chitieu">Chỉ tiêu</a>,
                                    <a href="/admin/dm-maunc">Loại mẫu nước</a>,
                                    <a href="/admin/dm-onhiem">Loại ô nhiễm</a>,
                                    <a href="/admin/dm-loaibv">Loại bệnh viện</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-database-add text-danger-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold">Công cụ</a></h6>
                                    <span>Hỗ trợ công cụ nhập liệu nhanh bằng file Excel cho </span>
                                    <a href="/admin/maunuoc-import">Mẫu nước</a>,
                                    <a href="/admin/vt-khaosat-import">Vị trí khảo sát</a>,
                                    <a href="/admin/poi-benhvien-import">Nước thải bệnh viên</a>,
                                    <a href="/admin/vt-onhiem-import">Vị trí khảo sát</a> và
                                    <a href="/admin/poi-thugomrac-import">Vị trí khảo sát</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-statistics text-blue-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/admin/thongke"
                                                                                      class="text-default">Thống kê</a>
                                    </h6>
                                    Thống kê các mẫu nước theo thời gian và loại mẫu
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-user-tie text-green-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/auth/user"
                                                                                      class="text-default">Quản trị hệ
                                            thống</a></h6>
                                    Quản lý thông tin người dùng và các quyền truy cập hệ thống
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <i class="icon-history text-warning-400 icon-2x mt-1"></i></a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading font-weight-semibold"><a href="/auth/log-user"
                                                                                      class="text-default">Lược sử</a>
                                    </h6>
                                    Lưu lại các thông tin truy cập và thao tác với hệ thống của người dùng
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">


        <!-- Đăng nhập gần đây -->
        <div class="card card-white">
            <div class="card-header">
                <h6 class="card-title text-semibold">
                    <i class="icon-enter2 position-left"></i>
                    Đăng nhập gần đây
                </h6>
            </div>
            <div class="card-body">
                <div class="list-feed">
                    <?php if (isset($activity_log)) {
                        foreach ($activity_log as $user) { ?>
                            <div class="list-feed-item border-warning-400">
                                <a href="/auth/user/view?id=<?= $user['causer_id'] ?>"><?= $user['fullname']; ?></a>
                                <div class="text-muted text-size-small mb-1"><?= $user['recent_time'] ?></div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
