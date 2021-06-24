<?php

namespace app\admin\controller;

use think\facade\View;
use think\facade\Db;

/**
 * Class suggestion
 * @author yourname
 */
class suggestion
{
	/**
	 * 返回用户意见列表视图
	 *
	 * @return void
	 */
	public function suggestion()
	{
		$data = DB::table('tp_advice')->select();

		/* 模型对象赋值给模版变量 */
		View::assign('data', $data);

		return View::fetch();
	}
}
