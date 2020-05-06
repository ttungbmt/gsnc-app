<?php
Yii::setAlias('@gsnc', dirname(__DIR__));

try {
    $path = dirname(__DIR__);
    $file = '.env';
    $dotenv = new Dotenv\Dotenv($path, $file);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {

}
