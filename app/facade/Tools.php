<?php

namespace app\facade;

use think\Facade;

/**
 * 定一个工具 门面类
 * @author yourname
 */
class Tools extends Facade
{
	protected static function getFacadeClass()
	{
		return '\app\tools\controller\Tools';
	}
}
