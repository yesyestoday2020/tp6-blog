<?php

namespace app\admin\controller;

use think\facade\View;
use think\facade\Db;
use app\admin\model\User;

class UserModify
{
	/**
	 * 用户资料修改
	 */
	public function usermodify()
	{
		$user = User::where('id', '>', 1)->select()->toArray();
		View::assign('vo', $user);
		return View::fetch();
	}

	/**
	 *保存用户数据
	 */
	public function saveData()
	{
		$name = input('post.name');
		$email = input('post.email');
		$save = Db::name('user')->update([
			'name' => $name,
			'email' => $email
		]);
		if ($save) {
			return 'success';
		} else {
			return 'error';
		}
	}
}
