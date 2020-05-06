<?php

use common\libs\activitylog\ActivityLogger;
use yii\bootstrap\Html;
use yii\helpers\Url;

if (!function_exists('opt')) {
    function opt($item) {
        return is_array($item) ? optional((object)$item) : optional($item);
    }
}


if (!function_exists('app')) {
    function app($abstract = null) {
        if (is_null($abstract)) {
            return Yii::$app;
        }

        return data_get(Yii::$app, $abstract);
    }
}

if (!function_exists('url')) {
    function url(...$args) {
        return Url::to(...$args);
    }
}

if (!function_exists('params')) {
    function params($key = null, $default = null) {
        $params = app('params');
        return is_null($key) ? $params : data_get($params, $key, $default);
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token() {
        return app('request')->getCsrfToken();
    }
}

if (!function_exists('db_command')) {
    function db_command($sql = null, $params = []) {

        return app('db')->createCommand($sql, $params);
    }
}

if (!function_exists('lang')) {
    function lang(...$args) {
        return Yii::t('app', ...$args);
    }
}


if (!function_exists('aliases')) {
    function aliases(...$args) {
        return Yii::getAlias(...$args);
    }
}

if (!function_exists('d')) {
    function d($var) {
        $debug = (array)debug_backtrace(1);
        $caller = array_shift($debug);
        echo '<code>File: ' . $caller['file'] . ' / Line: ' . $caller['line'] . '</code>';
        dd($var);
    }
}

if (!function_exists('asset')) {
    function asset($url) {
        $params = app('components.view.theme');
        if (!empty($params)) {
            $theme = Yii::createObject(array_merge(['class' => 'yii\base\Theme'], $params));
            return $theme->getUrl($url);
        }
        return url($url);
    }
}


if (!function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  array|string $key
     * @param null          $default
     *
     * @return mixed|\yii\console\Application|\yii\web\Application
     */
    function request($key = null, $default = null) {
        if (is_null($key)) {
            return app('request');
        }

        if (is_array($key)) {
            return app('request')->only($key);
        }

        $value = app('request')->input($key);

        return is_null($value) ? value($default) : $value;
    }
}

if (!function_exists('trans')) {
    function trans($category, $message, $params = [], $language = null) {
        return Yii::t($category, $message, $params, $language);
    }
}

if (!function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger {
        $defaultLogName = 'default';

        return with(new ActivityLogger)->useLog($logName ?? $defaultLogName);
    }
}

if (!function_exists('session')) {
    function session($key = null, $default = null) {
        $session = Yii::$app->session;
        if (is_null($key)) {
            return $session;
        }

        if (is_array($key)) {
            return $session->put($key);
        }

        return $session->get($key, $default);
    }
}


if (!function_exists('api')) {
    function api($url = null) {
        if (is_null($url)) {
            return app('api');
        }

        return app('api')->get($url);
    }
}

if (!function_exists('errorSummary')) {
    function errorSummary($models, $options = []) {
        return Html::errorSummary($models, array_merge([
            'class'  => 'alert alert-danger no-border',
            'header' => (
                '<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>' .
                '<p class="text-semibold">Vui lòng sửa các lỗi sau đây: </p>'
            )
        ], $options));
    }
}

if (!function_exists('getUserIpAddr')) {
    function getUserIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}

function isHttps() {
    return Yii::$app->request->isSecureConnection;

//    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
//
//        return true;
//    }
//    return false;
}





