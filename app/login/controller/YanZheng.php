<?php

namespace app\login\controller;

use app\admin\model\Admin;
use app\student\model\Student;

/**
 *验证功能
 **/
class YanZheng
{
	/**
	 * 管理员检测
	 *
	 * @return void
	 */
	public static function admin($username, $password)
	{
		/* 实例化管理员模型 */
		$admin = new Admin();
		/* 查询数据 */
		$adminInfo = $admin::where('username', $username)
			->where('status', 1)
			->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
			->find();

		if ($adminInfo == null) {
			$data = [
				'msg' => '管理员帐号不存在或被禁用',
				'val' => 0
			];
			return $data;
		}

		$check = loginCheck($password, $adminInfo->password);
		if ($check == true) {
			session('onlineCategory', 'admin');
			session('user_id', $adminInfo->id);
			session('username', $username);
			session('password', $password);
			$data = [
				'msg' => '验证成功',
				'val' => 1,
				'url' => '/'
			];
		} else {
			// 提示错误信息
			$data = [
				'msg' => '用户名或密码错误',
				'val' => 0
			];
		}
		return $data;
	}

	/**
	 * 学生检测
	 *
	 * @return void
	 */
	public static function student($username, $password)
	{
		/* 实例化学生模型 */
		$student = new Student();
		/* 查询数据 */
		$student_info = $student::where('shenfenzhenghao', $username)
			->where('status', 1)
			->field('id, lastip, shenfenzhenghao, ip, denglucishu, lasttime, thistime, password')
			->find();

		if ($student_info == null) {
			// 验证结果;
			$data = [
				'msg' => '学生帐号不存在或被禁用',
				'val' => 0
			];
			return $data;
		}

		$check = loginCheck($password, $student_info->password);
		if ($check === true) {
			session('onlineCategory', 'student');
			session('user_id', $student_info->id);
			session('username', $username);
			session('password', $password);
			// 跳转到首页
			$data = ['msg' => '验证成功', 'val' => 1, 'url' => '\\studentSearchChengji\\index\\index'];
		} else {
			// 提示错误信息
			$data = ['msg' => '用户名或密码错误', 'val' => 0];
		}

		return $data;
	}
}
