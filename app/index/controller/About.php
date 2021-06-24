<?php

declare(strict_types=1);

namespace app\index\controller;

use think\facade\View;

/**
 * about页面控制器
 */
class About {
	/**
	 * about页面视图
	 */
	public function about() {
		return 	View::fetch();
	}
}
