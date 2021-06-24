<?php

namespace app;

use think\Model;
use think\model\concern\SoftDelete;

/**
 *基础模型
 **/
class BaseModel extends Model
{
	// 开启全局自动时间戳
	protected $autoWriteTimestamp = true;

	// 开启软删除
	use SoftDelete;
	protected $deleteTime = 'delete_time';
}
