<?php

declare(strict_types=1);

namespace app\index\controller;

use think\facade\Db;

/* 引用用户模型 */

/* use app\index\model\User; */

use think\facade\View;

/* 引用验证码模块 */
use think\captcha\facade\Captcha;

class Login
{
	/* 返回视图 */
	public function login()
	{
		return 	View::fetch();
	}

	/* 调用验证码 */
	public function verify()
	{
		return Captcha::create();
	}

	/* 定义个处理ajax的方法 */
	public function index()
	{
		if (request()->isPost()) {
			$data = input('post.');

			$check_name = Db::name('user')->where('name', $data['name'])->find();

			if ($check_name) {
				header('Content-Type:text/html; charset=utf-8');
				return json($check_name);
			}
		}
	}
}
