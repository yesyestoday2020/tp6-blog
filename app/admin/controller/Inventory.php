<?php

namespace app\admin\controller;

use think\facade\View;
use think\facade\DB;
use think\facade\Request;

/**
 * 管理员控制器
 */
class Inventory {
	/**
	 * 管理员主页视图
	 */
	public function inventory() {
		return View::fetch();
	}

	/**
	 * 获取数据
	 */
	public function query() {
		$db = DB::name('product')->select();
		/* 每页限制条数 */
		$limit = Request::instance()->param('limit');
		/* 当前页 */
		$page = Request::instance()->param('page');
		/* 查询起始处 */
		$query = ($page - 1) * $limit + 1;
		$result = DB::name('product')->where('id', '>=', "$query")->limit(intval($limit))->select();
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
