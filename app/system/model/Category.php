<?php

namespace app\system\model;

use app\BaseModel;
use think\model\relation\HasMany;

class Category extends BaseModel
{
	/**
	 * 获取父级类型关联
	 *
	 * @return void
	 */
	public function glPid()
	{
		return $this->belongsToMany('Category', 'p_id', 'id');
	}

	/**
	 * 子类型关联
	 *
	 * @return void
	 */
	public function glCid()
	{
		return $this->hasMany('Category', 'p_id', 'id');
	}

	/**
	 * 查询所有类别
	 *
	 * @return void
	 */
	public function query($srcfrom)
	{
		$src = [
			'p_id' => '',
			'searchval' => ''
		];

		// 用新值替换初始值
		$src = array_cover($srcfrom, $src);
	}
}
