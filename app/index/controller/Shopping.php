<?php

namespace app\index\controller;

use think\facade\View;

/**
 * 购物车控制器
 */
class Shopping
{
	/**
	 * 购物车视图
	 */
	public function shop()
	{
		return View::fetch();
	}
}
