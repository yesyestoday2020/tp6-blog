<?php

namespace app\admin\controller;

use app\AdminBaseController;
use app\admin\model\Article as ModelArticle;
use app\admin\model\Category as ModelCategory;
use think\facade\View;

class Article extends AdminBaseController
{
	protected $mod;

	/**
	 * 定义一个构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		/* 模型实例化 */
		$this->mod = new ModelArticle();
		$category = new ModelCategory();

		/* 数据查询 */
		$type = $category->where(['status' => 1])->orderRaw('sort')->column('title', 'id');

		/* 模版赋值 */
		View::assign([
			'notes' => $this->mod->notes,
			'type' => $type,
		]);
	}

	/**
	 * 分页
	 */
	public function index()
	{
		/* 每页5条数据 */
		$pageSize = 5;

		/* 获取文章 id */
		$where = [];
		if (input('id')) {
			$where[] = ['id', '=', input('id')];
		}

		/* 数据查询 */
		$list = $this->mod->where($where)->order('id', 'desc')->paginage($pageSize);
		View::assign([
			'list' => $list
		]);
		return $this->adminTpl();
	}

	/**
	 * 文章编辑功能
	 */
	public function edit()
	{
		/* 在 thinkphp中 '/d'属于变量修饰服，强制将变量转化为整数 */
		$id = input('id/d', 0);

		/* 数据查询 */
		$info = $this->mod->where('id', $id)->find();

		/* post请求判断 */
		if (!request()->isPost()) {
			View::assign([
				'info' => $info
			]);
			return $this->adminTpl();
		}

		$data = input('post.');

		/* 销毁变量 s数组中的id元素 */
		unset($data['id']);
		$file = '';
		/* 文件保存路径 ，目录拼接*/
		/* base_path(): 获取 app目录的路径 */
		/* php的内置常量DIRECTORY_SEPARATOR是一个显示系统分隔符的命令 */
		$file_path = base_path() . 'public' . DIRECTORY_SEPARATOR . 'uploads';

		/* 图片上传 */
		/* $_FILES 是一个预定义的数组，用来获取通过 POST 方法上传文件的相关信息。 */
		/* 如果为单个文件上传，那么 $_FILES 为二维数组 */
		/* 如果为多个文件上传，那么 $_FILES 为三维数组 */
		if (!empty($_FILES['img']['tmp_name'])) {
			$file = request()->file('img');
		}
		/* 判断文件是否存在 */
		if ($file) {
			$img_path = config()['filesystem']['disks']['public']['url'];
			$savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file, 'md5');
			if ($savename) {
				$data['img'] = $img_path . DIRECTORY_SEPARATOR . $savename;
			} else {
				$this->jump(0, $file->getFileInfo());
			}
		}

		//更新数据
		if ($id) {
			$where['id'] = $id;
			$x = $this->mod->where($where)->update($data);
			//添加数据
		} else {
			$data['c_time'] = date('Y-m-d H:i:s');
			$x = $this->mod->insertGetId($data);
		}
		$x and $this->jump(1, '修改成功') or $this->jump(0, '修改失败');
	}

	/**
	 *编辑器图片上传功能
	 */
	public function UploadPic()
	{
		/* 接收文件 */
		$file = request()->file('info_upload_img');
		/* 文件保存目录 */
		$savename = \think\facade\Filesystem::disk('public')->putFile('articlePic', $file);
		/* 检测文件是否存在 */
		if ($savename) {
			$img = "/uploads/" . $savename;
			$save_info = ["success" => 1, 'data' => $img];
			return json($save_info);
		} else {
			$this->jump(0, $file->getFileInfo());
		}
	}
}
