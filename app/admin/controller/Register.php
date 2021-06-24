<?php

declare(strict_types=1);

namespace app\admin\controller;

use think\facade\Db;
use think\facade\View;
use think\captcha\facade\Captcha;


class Register {
	use \liliuwei\think\Jump;
	/**
	 * 注册页面视图
	 */
	public function register() {
		return 	View::fetch();
	}

	/**
	 * 处理ajax请求 
	 */
	public function get_data() {
		if (request()->isPost()) {
			$data = input('post.admin_user');
			$data['time'] = time();

			$check_name = Db::name('admin')->where('admin_user', $data['admin_user'])->find();

			return 	json($check_name);
			/* if (!$check_name) { */
			/* return 	json($check_name); */
			/* } */

			/* $data = [ */
			/* 	'name' => input('name'), */
			/* 	'password' => md5(input('password')), */
			/* 	'email' => input('email'), */
			/* 	'register_time' => $data['time'] */
			/* ]; */

			/* if (Db::name('admin')->insert($data)) { */
			/* 	return 	View::fetch('Admin/index'); */
			/* } else { */
			/* 	return 	View::fetch('Register/register'); */
			/* } */
		}
	}

	/**
	 * 验证码
	 */
	public function verify() {
		return Captcha::create();
	}

	/**
	 * undocumented function
	 */
	public function index() {
		return $this->success("注册成功", "Admin/index");
	}
}
