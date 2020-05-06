<?php
$db = [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'pgsql:host=localhost;dbname=gsnc_2019;port=5433;',
//    'dsn'      => 'pgsql:host=192.168.1.40;dbname=gsnc_2019;port=5432;',
    'username' => 'postgres',
    'password' => 'postgres',
    'charset'  => 'utf8',
];

return $db;
