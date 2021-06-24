<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\model\Category as ModelCategory;
use app\AdminBaseController;
use think\facade\View;

class Category extends AdminBaseController
{
	protected $mod;

	/**
	 * 初始化
	 */
	public function __construct()
	{
		parent::__construct();
		$this->mod = new ModelCategory();
		View::assign([
			'info' => $this->mod->notes
		]);
	}

	/**
	 *分页功能
	 */
	public function index()
	{
		$pageSize = 5;
		$where = [];
		if (input('id')) {
			$where[] = ['id', '=', input('id')];
		}
		/* 从数据库中获取所有数据 */
		$list = $this->mod->where($where)->order('id', 'desc')->paginate($pageSize);
		View::assign(['list' => $list]);
		return $this->adminTpl();
	}

	/**
	 * 修改功能
	 */
	public function edit()
	{
		$id = input('id/d', 0);
	}
}
