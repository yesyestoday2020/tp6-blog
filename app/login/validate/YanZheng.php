<?php

<<<<<<< HEAD
=======

>>>>>>> c8d4c32 (登陆功能后端完成)
namespace app\login\validate;

use think\Validate;

/**
 *验证规则
 **/
class YanZheng extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名'	=>	['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'username|用户名'  =>  'require',
		'password|密码'  =>  'require',
		'category|用户身份'  =>  'require',
	];

	protected $message = [
		'admin'  =>  [
			'username', 'password'
		],
		'fenliu'  =>  [
			'username', 'password', 'category'
		]
	];
}
