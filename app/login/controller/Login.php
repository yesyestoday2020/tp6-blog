<?php

namespace app\login\controller;

use app\admin\model\Admin;
use app\student\model\Student;
use app\BaseController;
use app\login\controller\YanZheng as YZ;
use app\system\model\SystemBase;

class Login extends BaseController
{
	/**
	 * 登陆主界面功能
	 *
	 * @return void
	 */
	public function login()
	{
		/* 清除 cookie */
		cookie('user_id', null);
		cookie('username', null);
		cookie('passwords', null);

		/* 清除会话 */
		session(null);

		$sysbasemod = new SystemBase();

		if ($sysbasemod) {
			$data = $sysbasemod::sysinfo();
		} else {
			/* 获取系统名称 */
			$data['sys_title'] = config('versioninfo.webtitle');
		}

		// 获取系统版本号
		$data['version'] = config('versioninfo.version');

		$this->view->assign('list', $data);

		// 渲染输出
		return $this->view->fetch('login');
	}

	/**
	 * 管理员登陆验证
	 *
	 * @return void
	 */
	public function admin()
	{
		$list = request()->only([
			'username',
			'password',
			'category'
		]);

		/* 调用验证器 */
		$validate = new \app\login\validate\YanZheng;
		$result = $validate->scene('admin')->check($list);
		$msg = $validate->getError();
		if (!$result) {
			return json([
				'msg' => $msg,
				'val' => 0
			]);
		}

		$yz = YZ::admin($list['username'], $list['password']);
		if ($yz['val'] === 1) {
			$admin_model = new Admin();
			$admininfo = $admin_model::where('username', $list['username'])
				->where('status', 1)
				->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
				->find();
			// 将本次信息上传到服务器上
			$admininfo->lastip = $admininfo->ip;
			$admininfo->ip = request()->ip();
			$admininfo->denglucishu = ['inc', 1];
			$admininfo->lasttime = $admininfo->getData('thistime');
			$admininfo->thistime = time();
			$admininfo->save();
		}
		return json($yz);
	}

	/**
	 * 学生登陆验证
	 *
	 * @return void
	 */
	public function student()
	{
		$list = request()->only([
			'username',
			'password',
			'category'
		]);

		/* 调用验证器 */
		$validate = new \app\login\validate\YanZheng;
		$result = $validate->scene('admin')->check($list);
		$msg = $validate->getError();
		if (!$result) {
			return json([
				'msg' => $msg,
				'val' => 0
			]);
		}

		$yz = YZ::student($list['username'], $list['password']);
		if ($yz['val'] === 1) {
			$student_model = new Student();
			$studentinfo = $student_model::where('username', $list['username'])
				->where('status', 1)
				->field('id, lastip, username, ip, denglucishu, lasttime, thistime, password')
				->find();
			// 将本次信息上传到服务器上
			$studentinfo->lastip = $studentinfo->ip;
			$studentinfo->ip = request()->ip();
			$studentinfo->denglucishu = ['inc', 1];
			$studentinfo->lasttime = $studentinfo->getData('thistime');
			$studentinfo->thistime = time();
			$studentinfo->save();
		}
		return json($yz);
	}

	// 系统更新日志
	public function updatelog()
	{
		// 渲染模板
		return $this->view->fetch();
	}

	/**
	 * 错误页面
	 *
	 * @return void
	 */
	public function myerror()
	{
		// 获取系统名称和版本号
		$list['webtitle'] = config('versioninfo.webtitle');
		$list['version'] = config('versioninfo.version');

		$this->view->assign('list', $list);

		// 渲染输出
		return $this->view->fetch();
	}

	/**
	 * 维护
	 *
	 * @return void
	 */
	public function weihu()
	{
		// 获取系统名称和版本号
		$list = [
			'shijian' => config('versioninfo.shijian'),
			'shichang' => config('versioninfo.shichang'),
			'webtitle' => '系统维护中',
			'version' => config('versioninfo.version')
		];
		$this->view->assign('list', $list);
		return $this->view->fetch();
	}
}
