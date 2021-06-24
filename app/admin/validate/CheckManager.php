<?php

declare(strict_types=1);

namespace app\admin\validate;

use think\Validate;

class CheckManager extends Validate {
	/**
	 * 验证规则 
	 */
	protected $rule = [
		'admin_user|管理员名字' => [
			'require',
			'max' => 25,
			'regex' => '/^[\w|\d]\w+/'
		],
		'admin_password|管理员密码' => [
			'require',
			'max' => 100,
		]
	];

	/**
	 * 错误信息提示 
	 */
	protected $message  = [
		'adminer_user.require' => '管理员姓名不能为空',
		'admin_user.max'     => '管理员姓名最多不能超过25个字符',
		'admin_password.require'  => '管理员密码不能为空',
	];

	/**
	 *定义登陆场景的验证
	 */
	protected $scene = [
		'edit' => ['oldpass', 'newpass'],
		'login' => ['name', 'password'],
	];
}
