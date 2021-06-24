<?php

namespace app\base\controller;

use app\BaseController;

abstract class AdminBase extends BaseController
{
	/**
	 * 控制器中间件
	 * @var array
	 */
	protected $middleware = [
		'online', 'login', 'auth'
	];

	// 初始化变量
	protected function initialize()
	{
		$this->online = session('onlineCategory');
		if ($this->online != 'admin') {
			\app\facade\OnLine::jump('/login', '请使用教师帐号登录');
		}
	}
}
