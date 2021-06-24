<?php

namespace app\facade;

use think\Facade;

/**
 * 定一个在线 门面类
 * @author yourname
 */
class OnLine extends Facade
{
	protected static function getFacadeClass()
	{
		return '\app\tools\controller\OnLine';
	}
}
