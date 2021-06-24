<?php

namespace app\student\model;

use app\BaseModel;

/**
 * 学生模型
 * @author yourname
 */
class Student extends BaseModel
{
	/**
	 * 学生班级
	 *
	 * @return void
	 */
	public function stuBanji()
	{
		return $this->belongsTo('\app\teach\model\Banji', 'banji_id', 'id');
	}
}
