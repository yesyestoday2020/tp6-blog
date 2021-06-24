<?php

namespace app\student\controller;

use app\base\controller\AdminBase;
use think\facade\View;

class Index extends AdminBase
{
	/**
	 * 学生列表
	 *
	 * @return void
	 */
	public function index()
	{
		$list['website'] = '学生列表';
		$list['dataurl'] = '/student/index/data';
		$list['status'] = '/student/index/status';
		$list['kaoshi'] = '/student/index/kaoshi';
		// 模板赋值
		$this->view->assign('list', $list);
		return View::fetch();
	}
}
