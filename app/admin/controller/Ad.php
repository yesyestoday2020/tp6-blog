<?php

namespace app\admin\controller;

use think\facade\View;


/**
 *广告位控制器
 * @return void
 */
class Ad
{
	/**
	 *广告视图
	 * @return 视图
	 */
	public function ad()
	{
		return View::fetch();
	}
}