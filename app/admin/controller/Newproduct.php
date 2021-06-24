<?php

namespace app\admin\controller;

use think\facade\View;
use think\facade\Db;

/**
 *新书上架控制器
 */
class Newproduct {

	/**
	 *新书上架视图
	 */
	public function newproduct() {
		return View::fetch();
	}

	/**
	 * 图片上传处理逻辑
	 */
	public function upload() {
		if (request()->isPost()) {
			/* 获取表单上的图片文件 */
			$file = request()->file("image");

			if ($file) {
				/* 保存目录 */
				$save_path = \think\facade\Filesystem::disk('public')->putFile('uploads', $file);
				// 拼接路径
				$path = \think\Facade\Filesystem::getDiskConfig('public', 'url') . str_replace('\\', '/', '/' . $save_path);

				if ($save_path) {
					$query = Db::name('product')->where('url', "")->find();
					if ($query) {
						Db::name('product')->where('id', $query['id'])
							->save(['url' => $path]);
					}

					$filename = $file->getFilename();
					//文件名称
					return json([
						'message' => '上传成功',
						'code' => 1,
						'filetype' => $file->getType(),
						'filename' => $filename,
						'filepath' => $path,
					]);
				} else {
					return json([
						'message' => '文件上传失败啦！',
						'code' => 0,
						'status' => 100
					]);
				}
			}
		}
	}

	/**
	 *接收表单数据
	 */
	public function formdata() {
		if (request()->isAjax()) {
			$racking_time = input('post.date');
			$data = [
				'title'  =>  input('post.title'),
				'desc'  =>  input('post.desc'),
				'price'  =>  input('post.price'),
				'interest'  =>  input('post.interest'),
				'racking_time' => $racking_time
			];
			$isSave = DB::name('product')->save($data);
			return json($isSave);
		}
	}
}
