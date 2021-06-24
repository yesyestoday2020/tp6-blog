<?php

namespace app\index\controller;

use think\facade\View;

/**
 * 收藏控制器
 */
class Collection {
	/**
	 *收藏视图
	 */
	public function collect() {
		return View::fetch();
	}
}
