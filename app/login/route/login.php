<?php

use think\facade\Route;

Route::group('', function () {

<<<<<<< HEAD
	/* 登陆页 */
	Route::rule('', 'Login/login', 'get');
	/* 管理员登陆 */
	Route::rule('', 'Login/admin', 'post');
	/* 学生登陆 */
	Route::rule('student', 'Login/student', 'post');
	/* 配置更新 */
	Route::rule('log', 'Login/updatelog', 'get');
	/* 错误页 */
	Route::rule('err', 'Login/myerror', 'get');
	/* 错误页 */
	Route::rule('weihu', 'Login/weihu', 'get');
=======
	Route::rule('', 'Login/login', 'get');
	Route::rule('', 'Login/admin', 'post');
	Route::rule('student', 'Login/student', 'post');
	Route::rule('log', 'Login/updatelog', 'get');		# 配置更新
	Route::rule('err', 'Login/myerror', 'get');			//错误页
	Route::rule('weihu', 'Login/weihu', 'get');			//错误页
>>>>>>> c8d4c32 (登陆功能后端完成)
});
