<?php

$data['nav_links'] = [
    [
        'path' => '/maps',
        'name' => 'Bản đồ',
        'icon' => 'icon-map5',
    ],
    [
        'path'  => '/admin',
        'name'  => 'Quản lý dữ liệu',
        'icon'  => 'icon-clipboard3',
        'attrs' =>
            [
                'target' => '_blank',
            ],
    ],
    [
        'path'  => '/maps/heatmap',
        'name'  => 'Heatmap',
        'icon'  => 'icon-lifebuoy',
    ],
];

$data['layer_keys'] = [
    'maunc'         => 'maunc',
    'poi_benhvien'  => 'poi_benhvien',
    'poi_thugomrac' => 'poi_thugomrac',
    'vt_khaosat'    => 'vt_khaosat',
    'vt_onhiem'   => 'vt_onhiem',
    'mangluoinuoc'  => 'mangluoinuoc',
];

$data['layer_tree'] = [
    [
        'title'    => 'Địa hình',
        'key'      => 'diahinh',
        'folder'   => true,
        'children' => [
            [
                'title'     => 'Quận huyện',
                'key'       => 'pg_ranhquan',
                'component' => [
                    'url'    => '/geoserver/ows?',
                    'layers' => 'dichte:dm_quan',
                ],
            ],
            [
                'title'     => 'Phường xã',
                'key'       => 'dm_phuong_vn',
                'component' => [
                    'url'    => '/geoserver/ows?',
                    'layers' => 'dichte:dm_phuong',
                ],
            ],
        ],
    ],
    [
        'title'     => 'Mạng lưới nước',
        'key'       => 'mangluoinuoc',
        'component' => [
            'url'    => '/geoserver/ows?',
            'layers' => 'gsnc:mangluoinuoc',
        ],
    ],
    [
        'title'     => 'Mẫu nước',
        'key'       => 'maunc',
        'checked'   => true,
        'component' => [
            'url'    => '/geoserver/ows?',
            'layers' => 'gsnc:v_maunc',
        ],
        'selected'  => true
    ],
    [
        'title'     => 'Vị trí khảo sát',
        'key'       => 'vt_khaosat',
        'component' => [
            'url'    => '/geoserver/ows?',
            'layers' => 'gsnc:v_vt_khaosat',
        ],
    ],
    [
        'title'     => 'Vị trí ô nhiễm',
        'key'       => 'vt_onhiem',
        'component' => [
            'url'    => '/geoserver/ows?',
            'layers' => 'gsnc:v_vt_onhiem',
        ],
    ],
    [
        'title'     => 'Điểm thu gom rác',
        'key'       => 'poi_thugomrac',
        'component' => [
            'url'    => '/geoserver/ows?',
            'layers' => 'gsnc:poi_thugomrac',
        ],
    ],
    [
        'title'     => 'Nước thải bệnh viện',
        'key'       => 'poi_benhvien',
        'component' => [
            'url'    => '/geoserver/ows?',
            'layers' => 'gsnc:poi_benhvien',
        ],
    ],
];


return $data;