<?php

namespace app\base\controller;

use app\BaseController;

class StudentSearchBase extends BaseController
{
	/**
	 * 控制器中间件
	 * @var array
	 */
	protected $middleware = [
		'online', 'login'
	];

	// 初始化变量
	protected function initialize()
	{
		$this->online = session('onlineCategory');
		if ($this->online != 'student') {
			\app\facade\OnLine::jump('/login', '请使用学生帐号登录');
		}
	}
}
