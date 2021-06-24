<?php

namespace app\student\validate;

use think\Validate;

/**
 * 学生验证
 *
 * @return void
 */
class YanZheng extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名'	=>	['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'id|ID'         =>     'require|number',
		'xingming|姓名'     =>  'require|chs|length:2,8',
		'sex|性别'            =>      'require|boolean',
		'shengri|出生日期'        =>      'date',
		'shenfenzhenghao|身份证号' =>      "require|idCard",
		'ruxuenian|年级'         =>      'require|number',
		'banji_id|班级'     =>      'require|number',
		'kaoshi|是否参加考试'            =>      'require|number',
		'quanpin|姓名全拼'      =>      'require',
		'xuehao|考号'      =>      'alphaNum|max:25'
	];

	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名'	=>	'错误信息'
	 *
	 * @var array
	 */
	protected $message = [];

	protected $scene = [
		'create'  =>  [
			'xingming', 'sex', 'shenfenzhenghao', 'ruxuenian', 'banji_id', 'kaoshi', 'xuehao'
		],
		'edit'  =>  [
			'id', 'xingming', 'sex', 'shenfenzhenghao', 'kaoshi', 'xuehao'
		],
		'onekaohao'  =>  [
			'id', 'xuehao'
		],
	];
}
