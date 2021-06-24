<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

//定义引用css、js等文件使用的常量 'SITE_URL'
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

/* 当应用模式下执行 */
/* $response = $http->run(); */

/* 多应用模式执行 */
$response = $http->name('index')->run();

$response->send();

$http->end($response);
