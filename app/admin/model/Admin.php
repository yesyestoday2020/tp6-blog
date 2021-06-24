<?php

namespace app\admin\model;

use app\BaseModel;

class Admin extends BaseModel
{
	/**
	 *查询所有角色
	 *
	 * @return void
	 */
	public function query($from)
	{
		$src = [
			'search_val' => ''
		];

		$src = array_cover($from, $src);

		$data = $this->where('id', '>', 2)
			->where('id', '<>', session('user_id'))
			->when(strlen($src['searchval']) > 0, function ($query) use ($src) {
				$query->where('xingming|username|quanpin|shoupin', 'like', '%' . $src['searchval'] . '%');
			})
			->with([
				'adSchool' => function ($query) {
					$query->field('id, jiancheng');
				}, 'glGroup'
			])
			->hidden([
				'password', 'create_time', 'update_time', 'delete_time'
			])
			->select();
		return $data;
	}

	/**
	 * 查询用户权限
	 *
	 * @return void
	 */
	public function queryAuth($user_id)
	{
		$data = self::where('id', $user_id)->field('id')->with(['glGroup'])->find();
		$arr = array();
		foreach ($data->glGroup as $key => $value) {
			$temp = explode(",", $value->rules);
			$arr = array_merge($arr, $temp);
		}
		$arr = array_unique($arr);

		return $arr;
	}

	/**
	 * 查询管理员资料
	 *
	 * @return void
	 */
	public function queryAdminInfo($id)
	{
		$adminInfo = $this->where('id', $id)
			->field('id, username, xingming, teacher_id')
			->find();
		return $adminInfo;
	}

	/**
	 * 根据姓名，首字母查询教师
	 *
	 * @return void
	 */
	public function queryTeacher($from)
	{
		$src = [
			'searchval' => '', 'school_id' => ''
		];

		$src = array_cover($from, $src);
		trim($src['searchval']);
	}


	/**
	 * 关联用户组
	 *
	 * @return void
	 */
	public function glGroup()
	{
		return $this->belongsToMany('AuthGroup', 'AuthGroupAccess', 'group_id', 'uid');
	}


	/**
	 *  单位关联模型
	 *
	 * @return void
	 */
	public function adSchool()
	{
		return $this->belongsTo('\app\system\model\School', 'school_id', 'id');
	}
}
