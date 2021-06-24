<?php

declare(strict_types=1);

namespace app\index\controller;

use app\BlogBaseController;
use think\facade\View;
use app\admin\model\Article;

/**
 * 主页控制器
 */
class Index extends BlogBaseController
{
	public function index()
	{
		/* 获取地址栏 url参数 */
		$type = input('type/d', 0);

		//每页显示5条数据 可自行修改
		$pageSize = 5;
		$mod = new Article();
		$where[] = ['status', '=', 1];
		if ($type) {
			$where[] = ['type', '=', $type];
			$map[] = ['type', '=', $type];
		}
		$list = $mod->where($where)->orderRaw('sort asc,id desc')->paginate($pageSize);
		/* 判断总记录数 */
		if (empty($list->total())) {
			return $this->jump404();
		}
		/* 判断当前页数是否大于上一页页数 */
		if ($list->getCurrentPage() > $list->lastPage()) {
			return redirect($type ? "/category/{$type}" : "/");
		}
		// 顶部轮播图 start
		$map[] = ['isbanner', '=', 1];
		$map[] = ['status', '=', 1];
		$tops = $mod->where($map)->orderRaw('id desc')->limit(5)->column('id,title,img', 'id');
		//顶部轮播图 end

		// 获取分页显示
		$page = $list->render();
		View::assign([
			'list' => $list,
			'type' => $type,
			'tops' => $tops,
			'page' => $page,
		]);
		return $this->blogTpl();
	}
}
