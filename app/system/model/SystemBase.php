<?php

namespace app\system\model;

use app\BaseModel;

class SystemBase extends BaseModel
{
	/**
	 * 系统信息
	 *
	 * @return void
	 */
	static function sysinfo()
	{
		$info = self::order(['id' => 'desc'])
			->field('id, keywords, description, sys_title, thinks, danwei, gradelist, studefen')
			->find();
		return $info;
	}

	/**
	 * 获取学年属性
	 *
	 * @return void
	 */
	public function getXuenianAttr($value)
	{
		$value = date('n月j日', $value);
		return $value;
	}

	/**
	 * 设置学年属性
	 *
	 * @return void
	 */
	public function setXuenianAttr($value)
	{
		$value = strtotime($value);
		$value = date('Y', time()) . '-' . date('m-d', $value);
		$value = strtotime($value);
		return $value;
	}
}
