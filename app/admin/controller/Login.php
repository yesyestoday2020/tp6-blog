<?php

namespace app\admin\controller;

use think\facade\View;
use think\captcha\facade\Captcha;
use app\admin\model\Admin;
use app\AdminBaseController;

class Login extends AdminBaseController
{
	/**
	 *登陆页视图模版
	 */
	public function index()
	{
		return View::fetch();
	}

	/**
	 *验证码显示
	 */
	public function verify()
	{
		return Captcha::create('verify');
	}

	/**
	 * 登陆
	 */
	public function login()
	{
		if (!request()->isPost()) {
			return $this->jump404();
		}

		/* 接收前端数据 */
		$username = input('username/s', '');
		$password = input('password/s', '');
		$captcha = input('captcha/s', '');

		/* 设置返回结果 */
		$error_info = [
			'status' => -1,
			'msg' => '账号/密码错误'
		];
		$success_info = [
			'status' => 1000,
			'msg' => '登录成功'
		];

		/* 用户名和密码都为空 */
		if (empty($username) || empty($password)) {
			return json($error_info);
		}

		/* 验证码检测 */
		if (!captcha_check($captcha)) {
			$errorret['msg'] = '验证码错误';
			return json($error_info);
		}

		/* 管理员模型实例化 ,查询数据*/
		$mod = new Admin();
		$where[] = ['username', '=', $username];
		$where[] = ['status', '=', 1];
		$info = $mod->where($where)->find();

		/* 判断返回结果 */
		if (empty($info)) {
			return json($error_info);
		}
		$password_info = $info['password'];
		if ($password_info !== AdminPassword($password)) {
			return json($error_info);
		}
		session('admin_uid', $info['adminid']);
		return json($success_info);
	}


	/**
	 *管理员退出,重定向到登陆页面
	 */
	public function loginOut()
	{
		session('admin_uid', null);
		$url =  url('/Index');
		return redirect($url);
	}
}
