<?php

namespace app\facade;

use think\Facade;

/**
 * 定一个系统 门面类
 * @author yourname
 */
class System extends Facade
{
	protected static function getFacadeClass()
	{
		return '\app\tools\controller\System';
	}
}
