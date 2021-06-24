<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 主页
use think\facade\Route;

Route::group('Admin', function () {
	# 信息列表
	Route::rule('', 'Admin/index', 'get');
	# 获取数据
	Route::rule('data', 'Admin/ajaxData', 'post');
	# 添加信息
	Route::rule('create', 'Admin/create', 'get');
	# 保存信息
	Route::rule('save', 'Admin/save', 'post');
	# 读取信息
	Route::rule('read/<id>', 'Admin/read', 'get');
	# 修改信息
	Route::rule('edit/<id>', 'Admin/edit', 'get');
	# 更新信息
	Route::rule('update/<id>', 'Admin/update', 'put');
	# 删除信息
	Route::rule('delete', 'Admin/delete', 'delete');
	# 删除信息
	Route::rule('status', 'Admin/setStatus', 'post');
	# 用户信息
	/* Route::rule('adminlist', 'Admin/adminList', 'post'); */
	# 用户信息
	Route::rule('downloadxls', 'Admin/downloadxls', 'get');
	# 批量导入
	Route::rule('createall', 'Admin/createAll', 'get');
	# 批量保存
	Route::rule('saveall', 'Admin/saveAll', 'post');
	# 查询教师
	Route::rule('srcteacher', 'Admin/srcAdmin', 'post');
	# 重置密码
	Route::rule('resetpassword/<id>', 'Admin/resetPassword', 'post');
	# 查询用户名是否已经存在
	Route::rule('srcusername', 'Admin/srcUsername', 'post');
	# 查询电话是否已经存在
	Route::rule('srcphone', 'Admin/srcPhone', 'post');
});

// 权限管理
Route::group('authrule', function () {
	Route::rule('', 'AuthRule/index', 'get');						# 信息列表
	Route::rule('data', 'AuthRule/ajaxData', 'post');				# 获取数据
	Route::rule('create', 'AuthRule/create', 'get');				# 添加信息
	Route::rule('save', 'AuthRule/save', 'post');					# 保存信息
	Route::rule('edit/<id>', 'AuthRule/edit', 'get');				# 修改信息
	Route::rule('update/<id>', 'AuthRule/update', 'put');			# 更新信息
	Route::rule('delete', 'AuthRule/delete', 'delete');		# 删除信息
	Route::rule('status', 'AuthRule/setStatus', 'post');		# 删除信息
	Route::rule('menu/<user_id>', 'AuthRule/menu', 'get');        # 删除信息
});


// 角色管理
Route::group('authgroup', function () {
	Route::rule('', 'AuthGroup/index', 'get');						# 信息列表
	Route::rule('data', 'AuthGroup/ajaxData', 'post');				# 获取数据
	Route::rule('create', 'AuthGroup/create', 'get');				# 添加信息
	Route::rule('save', 'AuthGroup/save', 'post');					# 保存信息
	Route::rule('edit/<id>', 'AuthGroup/edit', 'get');				# 修改信息
	Route::rule('update/<id>', 'AuthGroup/update', 'put');			# 更新信息
	Route::rule('delete', 'AuthGroup/delete', 'delete');		# 删除信息
	Route::rule('status', 'AuthGroup/setStatus', 'post');		# 删除信息
});


// 角色用户对应表
Route::group('authgroupaccess', function () {
	# 信息列表
	Route::rule('index/<group_id>', 'AuthGroupAccess/index', 'get');
	# 获取数据
	Route::rule('data', 'AuthGroupAccess/ajaxData', 'post');
	# 添加信息
	Route::rule('create/<group_id>', 'AuthGroupAccess/create', 'get');
	# 保存信息
	Route::rule('save', 'AuthGroupAccess/save', 'post');
	# 删除信息
	Route::rule('delete', 'AuthGroupAccess/delete', 'delete');
});


// 角色用户对应表
Route::group('tongbu', function () {
	Route::rule('index', 'Tongbu/index', 'get');
	Route::rule('teacher', 'Tongbu/teacher', 'post');
	Route::rule('bzr', 'Tongbu/bzr', 'post');
	Route::rule('chengji', 'Tongbu/chengji', 'post');
	Route::rule('dwry', 'Tongbu/dwry', 'post');
	Route::rule('file', 'Tongbu/file', 'post');
	Route::rule('jsry', 'Tongbu/jsry', 'post');
	Route::rule('kaoshi', 'Tongbu/kaoshi', 'post');
	Route::rule('ktcy', 'Tongbu/ktcy', 'post');
	Route::rule('tjbj', 'Tongbu/tjbj', 'post');
	Route::rule('bcks', 'Tongbu/kaoshiMoren', 'post');
});


// 管理员信息
Route::group('info', function () {
	Route::rule('read/<id>', 'AdminInfo/readAdmin', 'get');
	# 修改密码
	Route::rule('editpassword', 'AdminInfo/editPassword', 'get');
	# 更新密码
	Route::rule('updatepassword/<id>', 'AdminInfo/updatePassword', 'put');
	# 用户信息
	Route::rule('myinfo', 'AdminInfo/myInfo', 'get');
	# 查询荣誉
	Route::rule('srcry', 'AdminInfo/srcRy', 'post');
	# 查询课题
	Route::rule('srckt', 'AdminInfo/srcKt', 'post');
	# 查询课题
	Route::rule('srcbzr', 'AdminInfo/srcBzr', 'post');
	# 修改信息
	Route::rule('edit', 'AdminInfo/edit', 'get');
	# 更新信息
	Route::rule('update/<id>', 'AdminInfo/update', 'put');
});


Route::get('index', 'Admin/index');
Route::get('login', 'Admin/login');
Route::get('manager', 'Admin/manager');

Route::get('register', 'Register/register');
Route::get('verify', 'Register/verify');

Route::get('newproduct', 'Newproduct/newproduct');
Route::get('inventory', 'Inventory/inventory');
Route::get('userlist', 'UserList/userlist');
Route::get('orders', 'Orders/orders');
Route::get('suggestion', 'Suggestion/suggestion');
Route::get('ad', 'Ad/ad');
