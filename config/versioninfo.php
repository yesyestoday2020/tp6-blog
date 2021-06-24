<?php

use think\facade\Env;

return [
	'webtitle'         => '码蚁成绩管理',
	/* 版本号 */
	'version'         => 'v1.3.8',
	 /* 是否开启维护跳转 */
	'weihu'         => Env::get('versioninfo.weihu', false),  

  	 /* 开始时间 */
	'shijian'       => Env::get('versioninfo.weihushijian', '2020-1-1 0:00'),

	/*  时长:单位分钟 */
	'shichang'      => Env::get('versioninfo.weihuchixu', '100'),
	'backup'    => [
		/*数据库备份路径 */
		'path'     => './data/',

		/* 数据库备份卷大小 */
		'part'     => 20971520,

		/* 数据库备份文件是否启用压缩 0不压缩 1 压缩 */
		'compress' => 0,

		/* 数据库备份文件压缩级别 1普通 4 一般  9最高 */
		'level'    => 9

	],

 	# 是否开启教师只能录入自己任课班级的成绩
	'lurufanwei'    =>  Env::get('shangma.lurufanwei', false)
]
