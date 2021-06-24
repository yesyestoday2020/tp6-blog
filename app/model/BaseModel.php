<?php

declare(strict_types=1);

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @class 模型
 * 基础模型类
 */
class BaseModel extends Model
{
	/**
	 * @var 变量
	 * 自动写入时间戳
	 */
	protected $autoWriteTimestamp = true;

	use SoftDelete;

	/**
	 * @var 变量
	 * 删除时间
	 */
	protected $deleteTime = 'delete_time';
}
