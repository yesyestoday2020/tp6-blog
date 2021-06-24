<?php

namespace app\login\controller;

use think\Container;

class Error extends Controller
{
	/**
	 * 跳转页面
	 */
	public function index()
	{
		$this->error('不好意思，您访问的页面不存在~');
	}

	/**
	 * 跳转页面
	 */
	public function  _empty()
	{
		$this->error('不好意思，您访问的页面不存在~');
	}
}
