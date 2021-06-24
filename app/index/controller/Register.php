<?php

declare(strict_types=1);

namespace app\index\controller;

use think\facade\Db;

use think\facade\View;

/* 引入用户模型 */
use app\index\model\User;
use think\Request;

class Register
{
	public function register()
	{
		return 	View::fetch('register/register');
	}

	/* 处理ajax请求 */
	public function index(Request $request)
	{
		if ($request->isAjax(true)) {
			$data = input('post.');
			$data['time'] = time();

			$check_name = Db::name('user')->where('name', $data['name'])->find();

			if ($check_name) {
				return 	View::fetch('login/login');
				return 	\json($check_name);
			}

			$data = [
				'name' => input('name'),
				'password' => md5(input('password')),
				'email' => input('email'),
				'register_time' => $data['time']
			];

			if (Db::name('user')->insert($data)) {
				return 	View::fetch('index/index');
			} else {
				return 	View::fetch('register/register');
			}
		}
	}

	/**
	 * 使用User 模型
	 *
	 * @return void
	 */
	public function user()
	{
		$result = User::get(1);
		$result = $result->toArray();
		\dump($result);
	}
}
