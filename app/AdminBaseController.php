<?php

declare(strict_types=1);

namespace app;

use think\facade\View;

/**
 * 管理员控制器基类
 */
class AdminBaseController
{
	/**
	 * 控制器初始化
	 */
	public function __construct()
	{
		$this->initialize();
	}

	/**
	 * 初始化
	 */
	protected function initialize()
	{
		$admin_uid = session('admin_uid');

		/* 判断管理员用户id是否存在 */
		if (!$admin_uid) {
			/* 如果不存在重定向到登陆页面 */
			$url = url('/login');
			header('Location' . $url);
			exit;
		}
	}

	/**
	 * 跳转到404
	 */
	public function jump404()
	{
		abort(404, '页面异常');
	}

	/**
	 *定义空方法
	 */
	public function _empty()
	{
		return $this->jump404();
	}

	/**
	 * 管理员模版
	 */
	public function adminTpl()
	{
		return View::fetch('public/head') . View::fetch() . View::fetch('public/foot');
	}

	/**
	 * 	管理员公共模版
	 */
	public function adminPublicTpl()
	{
		return View::fetch('public/iframehead') . View::fetch() . View::fetch('public/iframefoot');
	}

	/**
	 * 自定义页面跳转方法
	 */
	public function jump($code = 1, $msg = '', $url = null, $data = '', $wait = 2, $header = [])
	{
		/* 判断 url是否为空 */
		if (is_null($url)) {
			/* 三元表达式,问号前面是判断,冒号前是结果1，冒号后是结果2 */
			/* 如果是 ajax请求则返回空值，否则返回前一条历史记录 */
			$url = request()->isAjax() ? '' : 'javascript:history.back(-1);';
		} elseif ('' !== $url) {
			/* strpos() 查找字符串在另一个字符串第一次出现的位置 */
			$url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app['url']->build($url);
		}

		$result = [
			'code' => (int) $code,
			'msg' => $msg,
			'data' => $data,
			'url' => $url,
			'wait' => $wait,
		];

		View::assign($result);
		echo View::fetch('public/head') . View::fetch('public/jump') . View::fetch('public/foot');
		exit;
	}
}
