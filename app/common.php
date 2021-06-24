<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件

use WhiteHat101\Crypt\APR1_MD5;

// 定义一个常量名,作者站点
define('AUTHOR_SITE_URL', 'https://www.wolfcode.net');

function checkWap()
{
	$HTTP_X_WAP_PROFILE = !empty($_SERVER['HTTP_X_WAP_PROFILE']);
	$HTTP_ACCEPT = $_SERVER['HTTP_ACCEPT'];
	$HTTP_USER_AGENT = strtolower($_SERVER['HTTP_USER_AGENT']);
	$HTTP_VIA = !empty($_SERVER['HTTP_VIA']) ?: null;

	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备  
	if (isset($HTTP_X_WAP_PROFILE)) {
		return true;
	}

	// 先检查是否为wap代理，准确度高
	if (stristr($HTTP_VIA, "wap")) {
		return true;
	}
	// 检查浏览器是否接受 WML.
	elseif (strpos(strtoupper($HTTP_ACCEPT), "VND.WAP.WML") > 0) {
		return true;
	}
	//检查USER_AGENT
	elseif (preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |googlebot-mobile|yahooseeker\/m1a1-r2d2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|ucweb|xda |xda_)/i', $HTTP_USER_AGENT)) {
		return true;
	} else {
		return false;
	}

	/**
	 *  后台admin用户密码
	 */
	function AdminPassword($password)
	{
		$en = md5(substr(md5($password), 2, 10));
		return $en;
	}
}

/*
	 * 定义一个数组替换函数
	 *
     * 根据键值，用数组2的值替换数组1的值
     * $cover 覆盖数组，存储新值的数组
     * $covered 被覆盖数组，被更改值的数组
     * 返回 新arr1
	 * @return void
	 */
function array_cover($cover = array(), $covered = array())
{
	$arr = \app\facade\Tools::array_cover($cover, $covered);
	return $arr;
}



/**
 * 登陆检测
 *
 * @return void
 */
function loginCheck($inputPassword, $serverPassword)
{
	//验证密码
	$check = APR1_MD5::check($inputPassword, $serverPassword);
	return $check;
}

/**
 * 把重新整理从数据模型中返回的对象
 * @access public
 * @param str或array $str 表单中获取的参数
 * @return array 返回类型
 */
function reSetObject($obj, $srcfrom)
{
	$data = \app\facade\Tools::reSetObject($obj, $srcfrom);
	return $data;
}
