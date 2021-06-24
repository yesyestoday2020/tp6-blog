<?php

namespace app\facade;

use think\Facade;

/**
 * 定一个文件 门面类
 * @author yourname
 */
class File extends Facade
{
	protected static function getFacadeClass()
	{
		return '\app\tools\controller\File';
	}
}
