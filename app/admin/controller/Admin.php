<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\admin\model\Admin as AdminMod;
use app\admin\validate\Admin as ValidateAdmin;
use app\base\controller\AdminBase;
use think\facade\View;
use WhiteHat101\Crypt\APR1_MD5;

/**
 * 管理员控制器
 */
class Admin extends AdminBase
{

	/**
	 *管理员主页
	 */
	public function index()
	{
		$list['webtitle'] = '管理员列表';
		$list['dataurl'] = '/admin/index/data';
		$list['status'] = '/admin/index/status';

		// 模板赋值
		$this->view->assign('list', $list);

		// 渲染模板
		return View::fetch();
	}

	/**
	 * 获取管理员数据
	 *
	 * @return void
	 */
	public function ajaxData()
	{
		/* 获取参数 */
		$src = $this->request
			->only([
				'page' => '1', 'limit' => '10', 'field' => 'id', 'order' => 'desc', 'searchval' => ''
			], 'POST');
		/* 实例化模型 */
		$adminmod = new AdminMod();
		$data = $adminmod->search($src)
			->visible([
				'id', 'xingming', 'sex', 'shengri', 'username', 'adSchool' => ['jiancheng'], 'glGroup' => ['title'], 'phone', 'thistime', 'lasttime', 'ip', 'denglucishu', 'status', 'update_time'
			]);
		$data = reSetObject($data, $src);
		return json($data);
	}

	/**
	 * 创建用户信息
	 *
	 * @return void
	 */
	public function create()
	{
		// 设置页面标题
		$list['set'] = array(
			'webtitle' => '添加管理员',
			'butname' => '添加',
			'formpost' => 'POST',
			'url' => 'save'
		);
		// 模板赋值
		$this->view->assign('list', $list);
		// 渲染
		return View::fetch('create');
	}

	/**
	 * 保存管理员
	 *
	 * @return void
	 */
	public function save()
	{
		// 获取表单数据
		$list = request()->only([
			'xingming',
			'quanpin',
			'shoupin',
			'username',
			'shengri',
			'sex',
			'phone',
			'school_id',
			'group_id',
			'zhiwu_id',
			'zhicheng_id',
			'xueli_id',
			'biye',
			'zhuanye',
			'worktime',
			'tuixiu',
			'beizhu'
		], 'POST');

		// 设置密码，默认为123456
		$md5 = new APR1_MD5();
		$list['password'] = $md5->hash('123456');

		$validate = new ValidateAdmin();
		$result = $validate->scene('admincreate')->check($list);
		$msg = $validate->getError();
		if (!$result) {
			return json(['msg' => $msg, 'val' => 0]);;
		}

		// 实例化管理员数据模型类
		$adminmod = new AdminMod();
		$admindata = $adminmod->create($list);
		$groupdata = $admindata->glGroup()->saveAll($list['group_id']);   # 更新中间表

		// 根据更新结果设置返回提示信息
		$admindata && $groupdata ? $data = ['msg' => '添加成功', 'val' => 1]
			: $data = ['msg' => '数据处理错误', 'val' => 0];

		// 返回信息
		return json($data);
	}

	/**
	 * 修改信息
	 *
	 * @return void
	 */
	public function edit($id)
	{
		// 获取用户信息
		$list['data'] = AdminMod::where('id', $id)
			->field('id, xingming, quanpin, shoupin, username, shengri, sex, phone, school_id, zhiwu_id, zhicheng_id, xueli_id, biye, zhuanye, worktime, tuixiu, beizhu')->with([
				'adSchool' => function ($query) {
					$query->field('id, jiancheng');
				}, 'glGroup' => function ($query) {
					$query->where('status', 1)->field('title, rules, miaoshu');
				}
			])->find();

		// 设置页面标题
		$list['set'] = array(
			'webtitle' => '编辑管理员',
			'butname' => '修改',
			'formpost' => 'PUT',
			'url' => '/admin/index/update/' . $id
		);

		// 模板赋值
		$this->view->assign('list', $list);
		// 渲染
		return View::fetch('create');
	}

	/**
	 * 更新管理员信息
	 *
	 * @return void
	 */
	public function update($id)
	{
		// 获取表单数据
		$list = request()->only([
			'xingming',
			'quanpin',
			'shoupin',
			'username',
			'shengri',
			'sex',
			'phone',
			'school_id',
			'group_id' => array(),
			'zhiwu_id',
			'zhicheng_id',
			'xueli_id',
			'biye',
			'zhuanye',
			'worktime',
			'tuixiu',
			'beizhu'
		], 'PUT');
		$list['id'] = $id;

		$list['group_id'] = array_values($list['group_id']);

		// 验证表单数据
		$validate = new ValidateAdmin;
		$result = $validate->scene('adminedit')->check($list);
		$msg = $validate->getError();
		if (!$result) {
			return json(['msg' => $msg, 'val' => 0]);;
		}
		// 更新管理员信息
		$adminmod = AdminMod::update($list);

		// 更新中间表
		$groupdata = $adminmod->glGroup()->detach();
		$groupdata = $adminmod->glGroup()->attach($list['group_id']);

		// 根据更新结果设置返回提示信息
		$adminmod && $groupdata ? $data = ['msg' => '更新成功', 'val' => 1]
			: $data = [
				'msg' => '数据处理错误',
				'val' => 0
			];

		// 返回信息
		return json($data);
	}






	/**
	 * 获取数据,分页查询
	 */
	/* public function query() */
	/* { */
	/* $db = Db::name('admin')->select(); */
	/* 每页限制条数 */
	/* $limit = Request::instance()->param('limit'); */
	/* 当前页 */
	/* $page = Request::instance()->param('page'); */
	/* 查询起始处 */
	/* $query = ($page - 1) * $limit + 1; */
	/* $result = Db::name('admin')->where('id', '>=', "$query")->limit(intval($limit))->select(); */
	/* $data = [ */
	/* 	"code" => 0, */
	/* 	"msg" => "数据请求成功", */
	/* 	"count" => $db->count(), */
	/* 	"limit" => $limit, */
	/* 	"page" => $page, */
	/* 	"query" => $query, */
	/* 	"data" => $result, */
	/* ]; */
	/* return json($data); */
	/* } */
}
