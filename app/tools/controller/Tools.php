<?php

declare(strict_types=1);

namespace app\tools\controller;

use app\BaseController;

class Tools extends BaseController
{

	/*
	 * 定义一个数组替换函数
	 *
     * 根据键值，用数组2的值替换数组1的值
     * $cover 覆盖数组，存储新值的数组
     * $covered 被覆盖数组，被更改值的数组
     * 返回 新arr1
	 * @return void
	 */
	public function array_cover($cover = array(), $covered = array())
	{
		foreach ($cover as $key => $value) {
			if ($value === "" || $value === null) {
				/* unset 销毁指定变量 */
				unset($cover[$key]);
			}
		}
		if (is_array($cover) && is_array($covered)) {
			foreach ($cover as $key => $value) {
				if (isset($covered[$key]) == true) {
					/* isset检测变量是否存在 */
					$covered[$key] = $cover[$key];
				}
			}
		}
		return $covered;
	}

	/**
	 * 把重新整理从数据模型中返回的对象
	 * @access public
	 * @param str或array $str 表单中获取的参数
	 * @return array 返回类型
	 */
	public function reSetObject($obj, $srcfrom)
	{
		// 整理变量
		$src = [
			'field' => '', 'order' => 'asc', 'page' => 1, 'limit' => 10
		];
		$src = array_cover($srcfrom, $src);

		$data = [
			'code' => 0  // ajax请求次数，作为标识符
			, 'msg' => ""  // 获取到的结果数(每页显示数量)
			, 'count' => 0 // 符合条件的总数据量
			, 'data' => '' //获取到的数据结果
		];

		// 整理数据
		$cnt = $obj->count();
		if ($cnt > 0) {
			if ($src['field'] != '') # 排序
			{
				$obj = $obj->order($src['field'], $src['order']);
			}
			$limit_start = $src['page'] * $src['limit'] - $src['limit'];
			$limit_length = $src['limit'] * 1;
			$obj = $obj->slice($limit_start, $limit_length);
			$data = [
				'code' => 0  // ajax请求次数，作为标识符
				, 'msg' => ""  // 获取到的结果数(每页显示数量)
				, 'count' => $cnt // 符合条件的总数据量
				, 'data' => $obj //获取到的数据结果
			];
		}
		return $data;
	}
}
