<?php

namespace app\index\controller;

use think\facade\View;

/**
 * 
 */
class Possess
{

	/**
	 * 拥有图书视图
	 */
	public function possess()
	{
		return View::fetch();
	}
}
