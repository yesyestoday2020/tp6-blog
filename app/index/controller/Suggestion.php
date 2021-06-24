<?php

declare(strict_types=1);

namespace app\index\controller;

use think\facade\View;
use think\facade\Db;

/**
 * 意见反馈
 */
class Suggestion {
	/**
	 * 意见反馈视图
	 */
	public function suggestion() {
		return View::fetch();
	}

	/**
	 * 处理意见反馈
	 */
	public function dosuggestion() {
		if (request()->isPost()) {
			$data = input('post.');

			$sql_info = Db::name('advice')->save(
				[
					"question" => $data["question"],
					"content" => $data["content"]
				]
			);

			$info = [
				"code" => 1,
				"msg" => "数据存储成功",
				"sql_info" => $sql_info

			];

			return json($info);

			/* if ($info == true) { */
			/* 	return "success"; */
			/* } else { */
			/* 	return "error"; */
			/* } */
		}
	}
}
