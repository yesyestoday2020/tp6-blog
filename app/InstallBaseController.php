<?php

declare(strict_types=1);

namespace app;

use think\facade\View;

class InstallBaseController
{
	/**
	 * 自定义一个构造方法
	 */
	public function __construct()
	{
		$this->initialize();
	}

	/**
	 * 自定义一个初始化方法
	 */
	public function initialize()
	{
		/* 项目版本 */
		$version = \think\App::VERSION;
		/* 标题 */
		$powered = '内容管理系统';
		View::assign([
			/* 版本 */
			'version' => $version,
			'powered' => $powered,
			/* 默认数据库 */
			'default_dbname' => 'wolfcode_blog',
			/* 作者站点 */
			'wolfcode_url' => AUTHOR_SITE_URL,
		]);
	}

	/**
	 * 页面异常,跳转到404
	 */
	public function jump404()
	{
		abort(404, '页面异常');
	}

	//空方法
	public function _empty()
	{
		return $this->jump404();
	}

	public function installTpl()
	{
		//获取当前控制器，并转化为小写
		$contrroller = strtolower(request()->controller());
		/* 获取当前操作名 ,并转换成小写*/
		$action = strtolower(request()->action());
		//直接引入头部和底部文件，在新建页面模版的时候省去重复引入的环节
		return View::fetch('public/head') . View::fetch() . View::fetch('public/foot');
	}
}
