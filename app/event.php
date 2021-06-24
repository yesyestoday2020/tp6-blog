<?php
// 事件定义文件
return [
	'bind'      => [
		'myevent' => 'app\event\MyEvent',
	],

	'listen'    => [
		'AppInit'  => [],
		'HttpRun'  => [],
		'HttpEnd'  => [],
		'LogLevel' => [],

		/* 考试录入 */
		'kslu' => [
			'\app\listener\KaoshiLuru'
		],
		/* 考试编辑 */
		'ksedit' => [
			'\app\listener\KaoshiEdit'
		],
		/* 日志统计 */
		'tjlog' => [
			'\app\listener\TongjiLog'
		],
		/* 考试统计 */
		'kstj' => [
			'\app\listener\KaoshiTongJi'
		],
		/* 班级id */
		'mybanji' => [
			'\app\listener\MyBanjiIds'
		],
		/* 录入分工 */
		'lrfg' => [
			'\app\listener\LuruFengong'
		],
	],

	'subscribe' => [],
];
