<?php

namespace app\index\controller;

use app\BlogBaseController;
use app\admin\model\Article;
use think\facade\View;

class Info extends BlogBaseController
{
	protected $mod;
	/***
	 * 博客内容详情
	 */
	public function index()
	{
		/* 接收地址栏 id参数 */
		$id = input('id/d', 0);
		/* 判断id是否存在 */
		if (!$id) {
			return $this->jump404();
		}

		/* 模型实例化，并查询数据 */
		$mod = new Article();
		$info = $mod->find($id);

		/* 判断查询结果是否存在 */
		if (!$info) {
			return $this->jump404();
		}

		View::assign([
			'info' => $info,
			'type' => $info['type'],
			'title' => $info['title'],
		]);

		return $this->blogTpl();
	}
}
