<?php

declare(strict_types=1);

namespace app\index\controller;

use think\facade\View;

/**
 * 系统通知控制器
 */
class Notify
{
	/**
	 * 系统通知视图
	 */
	public function notify()
	{
		return 	View::fetch();
	}
}
