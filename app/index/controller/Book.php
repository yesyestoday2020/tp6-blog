<?php

namespace app\index\controller;

use think\facade\View;

/**
 *图书商城控制器
 */
class Book {

	/**
	 *显示图书商城
	 */
	public function book() {
		return View::fetch();
	}

	/**
	 *获取数据
	 */
	public function getData() {
		return null;
	}
}
