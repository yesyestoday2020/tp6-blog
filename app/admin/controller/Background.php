<?php

declare(strict_types=1);

namespace app\admin\controller;


use app\admin\model\Background as ModelBackground;/* 调用模型并设置别名 */
use app\AdminBaseController;
use think\facade\View;

class Background extends AdminBaseController
{
	protected $mod;

	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->mod = new ModelBackground();
		View::assign([
			'notes' => $this->mod->notes
		]);
	}

	/**
	 * 分页显示功能
	 */
	public function index()
	{
		$pageSize = 5;
		$where = [];
		if (input('id')) {
			$where[] = ['id', '=', input('id')];
		}

		$list = $this->mod->Where($where)->orderRaw('id  desc')->paginate($pageSize, false, []);

		View::assign([
			'list' => $list,
		]);

		return $this->adminTpl();
	}

	/**
	 *编辑修改功能
	 */
	public function edit()
	{
		$id = input('id/d', 0);
		$info = $this->mod->where('id', $id)->find();
		if (!request()->isPost()) {
			View::assign([
				'info' => $info
			]);
			return $this->adminTpl;
		}

		$data = input('post.');
		unset($data['id']);

		$file = $file2 = '';
		if (!empty($_FILES['head_back_img']['tmp_name'])) {
			$file = request()->file('head_back_img'); //图片上传  
		}

		if (!empty($_FILES['main_back_img']['tmp_name'])) {
			$file2 = request()->file('main_back_img'); //图片上传
		}

		$img_path = config()['filesystem']['disks']['public']['url'];
		/* 头部背景图片上传 */
		if ($file) {
			$savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file, 'md5');
			if ($savename) {
				$data['head_back_img'] = $img_path . DIRECTORY_SEPARATOR . $savename;
			}
		}
		/* 主体背景图片上传 */
		if ($file2) {
			$savename2 = \think\facade\Filesystem::disk('public')->putFile('topic', $file2, 'md5');
			if ($savename2) {
				$data['main_back_img'] = $img_path . DIRECTORY_SEPARATOR . $savename2;
			}
		}
		if ($id) { //更新数据
			$where['id'] = $id;
			$x = $this->mod->where($where)->update($data);
		} else { //添加数据
			$data['c_time'] = date('Y-m-d H:i:s');
			$x = $this->mod->insertGetId($data);
		}
		$x and $this->jump(1, '修改成功') or $this->jump(0, '修改失败');
	}
}
