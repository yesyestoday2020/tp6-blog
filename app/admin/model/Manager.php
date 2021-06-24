<?php

namespace app\admin\model;

use think\model;

/**
 *管理员模型
 */
class Manager extends Model {
	/* 模型初始化 */

	protected static function init() {
		//TODO:初始化内容
		parent::init();
	}

	/**
	 * 检查登陆错误 
	 */
	public function checkLoginerror($username, $password) {

		/* 检查用户是否存在 */
		$result = $this->where(['username' => $username])->find();
		if (empty($result)) {
			return '用户不存在';
		}

		/* 检查秘密是否匹配 */
		$result = $this->where(['username' => $username, 'password' => sha1($password)])->find();
		if (empty($result)) {
			return '秘密错误';
		}

		/* 检查账号是否被冻结 */
		if ($result['status'] == 0) {
			return '账号已冻结';
		}

		$this->recordLoginInfo($result);
		return null;
	}

	/**
	 *记录登陆信息
	 */
	public function name($param) {
	}
}
