<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 主页
use think\facade\Route;

Route::get('index', 'Index/index');

/* Route::get('about', 'About/about'); */

/* Route::get('book', 'Book/book'); */

/* Route::get('login', 'Login/login'); */
/* Route::get('verify', 'Login/verify'); */

/* Route::get('register', 'Register/register'); */
/* Route::get('suggestion', 'suggestion/suggestion'); */
/* Route::get('shop', 'shopping/shop'); */
/* Route::get('collect', 'Collection/collect'); */
/* Route::get('possess', 'Possess/possess'); */
/* Route::get('notify', 'Notify/notify'); */

Route::any('category/:type', 'Index/Index/index');
Route::any('info/:id', 'index/Info/index');
