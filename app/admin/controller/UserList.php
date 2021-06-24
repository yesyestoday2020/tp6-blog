<?php

namespace app\admin\controller;

use think\facade\Db;
use think\facade\View;
use think\facade\Request;

/**
 * 用户列表控制器
 *
 */
class UserList {
	/**
	 * 用户列表视图 
	 */
	public function userlist() {
		return View::fetch();
	}

	/**
	 * 获取后端数据
	 */
	public function getData() {
		$db = DB::name('user')->select();
		/* 每页限制条数 */
		$limit = Request::instance()->param('limit');
		/* 当前页 */
		$page = Request::instance()->param('page');
		/* 查询起始处 */
		$query = ($page - 1) * $limit + 1;
		$result = DB::name('user')->where('id', '>=', "$query")->limit(intval($limit))->select();
		$data = [
			"code" => 0,
			"msg" => "数据请求成功",
			"count" => $db->count(),
			"limit" => $limit,
			"page" => $page,
			"data" => $result,
		];
		return json($data);
	}
}
