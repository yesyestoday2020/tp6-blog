<?php

declare(strict_types=1);

namespace app;

use app\BaseController;
use app\admin\model\Background;
use app\admin\model\Category;
use think\facade\View;

class BlogBaseController extends BaseController
{
	/**
	 * 自定义构造方法
	 * 调用初始化方法
	 */
	public function __construct()
	{
		/* 载入文件 */
		include_once dirname(__FILE__) . '/define.php';

		$this->initialize();
	}

	/**
	 * 自定义初始化方法
	 * 调用检查安装方法
	 */
	public function initialize()
	{
		$this->checkInstall();
	}

	/**
	 * 定义检查安装方法
	 */
	protected function checkInstall()
	{
		/* 目录拼接 */
		$lock_file = root_path() . 'wcore' . DIRECTORY_SEPARATOR . 'install.lock';

		/* 检查文件是否存在 */
		if (file_exists($lock_file)) {
			return TRUE;
		}

		/* 重定向到安装页面 */
		header('Location:/install.php');
		exit;
	}

	/**
	 *定义空方法
	 */
	public function _empty()
	{
		return $this->jump404();
	}

	/**
	 *显示404页面
	 */
	public function jump404()
	{
		abort(404, '页面异常');
	}

	/**
	 *定义一个博客模版方法
	 */
	public function blogTpl()
	{
		/* 模型实例化 */
		$category = new Category();
		$background = new Background();

		/* 数据查询 */
		$headernav = $category->where(['status' => 1])->order('sort ascc')->column('title', 'id');
		/* 查询 id=1 */
		$backing = $background->find(1);

		View::assign(['headernav' => $headernav, 'backing' => $backing]);
		return View::fetch('public/head') . View::fetch() . View::fetch('public/foot');
	}
}
