<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'           => 'app-gsnc',
    'defaultRoute' => 'admin/site/index',

    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'gsnc\controllers',
    'modules'             => [
    ],

    'components' => [
        'api'  => [
            'class'   => 'common\components\Api',
            'dataMap' => [
                dirname(__DIR__) . '/fixtures/danhmuc.php',
            ]
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/admin',
                'baseUrl'  => '@web/gsnc',
                'pathMap'  => [
                    '@app/views' => [
                        '@app/themes/admin',
                        '@common/themes/admin',
                    ],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'gsnc*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],

        'user'    => [
            'identityCookie' => ['name' => '_identity-gsnc', 'httpOnly' => true],
        ],
        'request' => [
            'csrfParam' => '_csrf-gsnc',
            'parsers'   => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'session' => [
            'name' => 'advanced-gsnc',
        ],
        'log'     => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'      => require __DIR__ . './db.php'
    ],
    'params'     => $params,

    'as beforeRequest' => [
        'class'  => 'yii\filters\AccessControl',
        'only'   => ['admin/*'],
        'except' => [
            //'admin/*'
        ],
        'rules'  => [
            [
                'allow' => true,
                'roles' => ['@']
            ],
        ],
    ],
];


