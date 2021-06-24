<?php

namespace app\admin\model;

use think\model;

class Article extends Model
{
	public $notes = [
		'status' => [
			1 => '正常',
			0 => '禁用'
		],
		'isbanner' => [
			1 => '推荐',
			0 => '不推荐'
		]
	];
}
