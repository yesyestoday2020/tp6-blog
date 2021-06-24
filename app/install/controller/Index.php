<?php

namespace app\install\controller;

use app\InstallBaseController;
use think\facade\View;

class Index extends InstallBaseController
{

	public function __construct()
	{
		parent::__construct();
		/* 定义根目录 */
		define('ROOT_PATH', root_path());
		/* 指定安装锁定文件 */
		$installlocak_file = ROOT_PATH . 'wcore' . DIRECTORY_SEPARATOR . 'install.lock';
		/* 判断文件是否存在 */
		if (file_exists($installlocak_file)) {
			/* 重定向到主页 */
			header('Location:/');
			exit;
		}
	}

	/**
	 * 安装视图
	 */
	public function index()
	{
		return $this->installTpl();
	}

	/**
	 * 步骤2,检测环境
	 */
	public function step2()
	{
		$err = 0;
		$phpversion = $mysql = $uploadSize = $session = $curl = '';
		/* version_compare() php 版本字符串比较*/
		if (version_compare(PHP_VERSION, '7.1.0', '<')) {
			$phpversion = correct_span(PHP_VERSION, 0);
			$err++;
		} else {
			$phpversion = correct_span(PHP_VERSION, 1);
		}

		/* 检查 PDO类是否已经定义 */
		if (class_exists('pdo')) {
			$mysql = correct_span("已安装PDO扩展", 1);
		} else {
			//如果没有安装PDO扩展，在检查是否安装MYSQLI扩展
			if (class_exists('mysqli')) {
				$mysql = correct_span("已安装MYSQLI扩展", 1);
			} else {
				$mysql = correct_span("未安装PDO和MYSQLI", 0);
				$err++;
			}
		}

		/* 获取配置选项的值 */
		if (ini_get('file_uploads')) {
			$uploadSize = correct_span(ini_get('upload_max_filesize'), 1);
		} else {
			$uploadSize = correct_span("禁止上传", 0);
		}

		/* 检测函数是否被定义 */
		if (function_exists('session_start')) {
			$session = correct_span("支持", 1);
		} else {
			$session = correct_span("不支持", 0);
			$err++;
		}
		if (function_exists('curl_init')) {
			$curl = correct_span("支持", 1);
		} else {
			$curl = correct_span("不支持", 0);
			$err++;
		}

		/* 目录文件权限检查 */
		$folder = ['runtime', 'wcore', 'public/uploads'];
		foreach ($folder as $dir) {
			$testdir = ROOT_PATH . $dir;
			if (testwrite($testdir)) {
				$w = correct_span("可写", 1);
			} else {
				$w = correct_span("不可写", 0);
				$err++;
			}
			/* is_readable() 检查文件目录是否可读*/
			if (is_readable($testdir)) {
				$r = correct_span("可读", 1);
			} else {
				$r = correct_span("不可读", 0);
				$err++;
			}
		}
		/* 模版赋值 */
		View::assign([
			'phpversion' => $phpversion,
			'mysql' => $mysql,
			'uploadSize' => $uploadSize,
			'session' => $session,
			'curl' => $curl,
			'folder' => $folder,
			'err' => $err,
		]);
		return $this->installTpl();
	}

	/**
	 * 步骤3,获取网站域名
	 */
	public function step3()
	{
		/* 获取当前域名 */
		$domain = request()->domain();
		/* 模版赋值 */
		View::assign([
			'domain' => $domain,
			'webPath' => ROOT_PATH,
		]);
		/* 设定文件的访问和修改时间 */
		@touch(ROOT_PATH . 'wcore' . DIRECTORY_SEPARATOR . 'step2_successed.lock');
		return $this->installTpl();
	}

	/**
	 * 安装视,图步骤4
	 */
	public function step4()
	{
		if (!request()->isPost()) {
			/* 构建url */
			$url = url('/index/index')->build();
			/* 重定向到 url */
			header('Location: ' . $url);
			exit;
		}
		/* 获取令牌 */
		$check = request()->checkToken('__token__');
		/* 令牌判断 */
		if (false === $check) {
			/* 构建url */
			$url = url('/index/step3')->build();
			/* 重定向到 url */
			header('Location: ' . $url);
			exit;
		}
		View::assign(['post' => input('post.'),]);
		/* 创建 step3_successed.lock文件 */
		@touch(ROOT_PATH . 'wcore' . DIRECTORY_SEPARATOR . 'step3_successed.lock');
		return $this->installTpl();
	}

	/**
	 * 安装视图步骤5
	 */
	public function step5()
	{
		/* 判断 step4_successed.lock 文件是否存在，不存在的话创建该文件 */
		if (file_exists(ROOT_PATH . 'wcore' . DIRECTORY_SEPARATOR . 'step4_successed.lock')) {
			@touch(ROOT_PATH . 'wcore' . DIRECTORY_SEPARATOR . 'install.lock');
		}
		return $this->installTpl();
	}


	/**
	 * 安装数据库
	 */
	public function installDb()
	{
		/* 获取前端数据 */
		$n = input('get.n/d', 0);

		$error = ['code' => 0, 'msg' => 'error', 'n' => $n];
		$success = ['code' => 1, 'msg' => 'success', 'n' => $n];

		/* 判断 ajax请求 */
		if (!request()->isAjax()) {
			return json($error);
		}

		/* 获取表单数据 */
		$dbType = input('post.dbtype/s', 'pdo', 'trim');
		$dbHost = input('post.dbhost/s', '', 'trim');
		$dbPort = input('post.dbport/d', '', 'trim');
		$dbName = input('post.dbname/s', 'wolfcode_blog', 'trim');
		$dbUser = input('post.dbuser/s', '', 'trim');
		$dbPwd = input('post.dbpw/s', '', 'trim');
		$dbPrefix = input('post.dbprefix/s', '', 'trim');
		$dbCahrset = input('post.dbcharset/s', 'utf8', 'trim');
		$adminname = input('post.manager_adminname/s', '', 'trim');
		$password = input('post.manager_pwd/s', '', 'trim');

		/* 数组赋值 */
		$config = [];
		/* in_array() 检查数组中是否存在某个值*/
		$config['db_type'] = in_array($dbType, ['pdo', 'mysqli', 'mysql']) ? $dbType : 'pdo';
		$config['db_host'] = $dbHost;
		$config['db_name'] = $dbName;
		$config['db_user'] = $dbUser;
		$config['db_pwd'] = $dbPwd;
		$config['db_port'] = $dbPort;
		$config['db_prefix'] = $dbPrefix;

		/* 获取数据库链接异常 */
		try {
			$conn = mysqli_connect($dbHost, $dbUser, $dbPwd, null, $dbPort);
		} catch (\Exception $e) {
			$error['msg'] = correct_span("连接 MySQL 失败: " . mysqli_connect_error() . ' 请刷新本页面后检查数据库账号密码', 0);
			return json($e->$error);
		}

		/* 获取mysql服务器版本 */
		$mysql_version = mysqli_get_server_info($conn);
		/* 分割字符串 */
		$exp_mysql = explode('.', $mysql_version);
		if (count($exp_mysql) < 3) {
			/* 向数组末尾插入数据 */
			array_push($exp_mysql, '0');
		}
		/* list() 给一组变量赋值 */
		list($m, $s, $q) = $exp_mysql;
		if ($m < 5) {
			$error['msg'] = correct_span("MySQL 版本太低，当前版本 {$mysql_version} ，需要最低 5+", 0);
			mysqli_close($conn);
			return json($error);
		}
		// MySQL 小于 5.5.3 不支持 utf8mb4
		if ($m == 5) {
			if ($s < 5) {
				if ($dbCahrset == 'utf8mb4') {
					$error['msg'] = correct_span("MySQL 版本太低，当前版本 {$mysql_version} ，utf8mb4 编码最低要求版本 5.5.3+", 0);
					mysqli_close($conn);
					return json($error);
				}
			}
			if ($s == 5 && $q < 3) {
				if ($dbCahrset == 'utf8mb4') {
					$error['msg'] = correct_span("MySQL 版本太低，当前版本 {$mysql_version} ，utf8mb4 编码最低要求版本 5.5.3+", 0);
					mysqli_close($conn);
					return json($error);
				}
			}
		}
		mysqli_query($conn, "SET NAMES {$dbCahrset}");
		if (!mysqli_select_db($conn, $dbName)) {
			if (!mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET {$dbCahrset};")) {
				$error['msg'] = correct_span("数据库{$dbName} 不存在，也没权限创建新的数据库！", 0);
				mysqli_close($conn);
				return json($error);
			}
			if (!$n) {
				$success['n'] = 1;
				$success['msg'] = '<li>' . correct_span("成功创建数据库 {$dbName}", 1) . '</li> ';
				mysqli_close($conn);
				return json($success);
			}
			mysqli_select_db($conn, $dbName);
		}

		//读取数据文件
		//判断文件是否存在
		$dbbase_file = ROOT_PATH . 'extend' . DIRECTORY_SEPARATOR . 'database.sql';
		if (file_exists($dbbase_file) === false) {
			$error['msg'] = correct_span("数据库基础获取异常，请确认{$dbbase_file}文件是否存在", 0);
			mysqli_close($conn);
			return json($error);
		}

		/* 获取文件内容 */
		$sqldata = file_get_contents($dbbase_file);
		$sqlFormat = sql_split($sqldata, $dbPrefix);
		$counts = count($sqlFormat);
		$message = '';
		for ($i = $n; $i < $counts; $i++) {
			$sql = trim($sqlFormat[$i]);
			if (strstr($sql, 'CREATE TABLE')) {
				preg_match('/CREATE TABLE `([^ ]*)`/', $sql, $matches);
				//mysqli_query($conn, "DROP TABLE IF EXISTS `$matches[1]");
				$ret = mysqli_query($conn, $sql);
				$db_title = $matches[1] ?? "";
				if ($ret) {
					$message .= '<li>' . correct_span("创建数据表 {$db_title} 完成", 1) . '</li> ';
				} else {
					$message .= '<li>' . correct_span("创建数据表 {$db_title} 失败，请检查该数据表是否已经存在", 0) . '</li> ';
				}
				$i++;
				$success['msg'] = $message;
				$success['n'] = $i;
				return json($success);
			}
		}

		if ($i < 1) {
			$message = '创建数据表失败';
			$error['msg'] = $message;
			$error['n'] = 0;
			mysqli_close($conn);
			return json($error);
		}
		if ($i == 999999) {
			$success['n'] = $i;
			mysqli_close($conn);
			return json($success);
		}

		//插入管理员
		$md5_password = AdminPassword($password);
		$time = time();
		$query = "INSERT INTO `{$dbPrefix}admin` VALUES ('1', '{$adminname}', '{$md5_password}', '1', '超级管理员', '', '', '', '0', '', '{$time}', '系统',1)";
		$ret = mysqli_query($conn, $query);

		/* sql数据文件,插入 sqldata.sql数据 */
		/* 判断文件是否存在 */
		$sql_data = ROOT_PATH . 'extend' . DIRECTORY_SEPARATOR . 'sqldata.sql';
		if (file_exists($sql_data)) {
			$sql2 = file_get_contents($sql_data);
			if (!mysqli_select_db($conn, $dbName)) {
				$message = "数据库{$dbName}不存在！";
				$error['msg'] = $message;
				$error['n'] = 0;
				mysqli_close($conn);
				return json($error);
			}
			$exp = array_filter(explode('INSERT INTO', ($sql2)));
			$count = count($exp) + 1;
			$value = '';
			$result2 = FALSE;
			foreach ($exp as $key => $value) {
				$query_sql = 'INSERT INTO ' . htmlspecialchars_decode($value);
				$result2 = mysqli_query($conn, $query_sql);
			}
		}
		mysqli_close($conn);
		if ($ret) {
			$message = correct_span('添加后台管理员成功', 1);
			$success['msg'] = $message;
			$success['n'] = 999999;
			/* 创建 step4_successed.lock 文件 */
			@touch(ROOT_PATH . 'wcore' . DIRECTORY_SEPARATOR . 'step4_successed.lock');
			return json($success);
		} else {
			$message = correct_span('添加后台管理员失败', 0);
			$error['msg'] = $message;
			$error['n'] = 0;
			return json($error);
		}
	}

	/**
	 * 检测Db数据库连接
	 */
	public function checkdb()
	{
		/* 设置信息 */
		$error = ['code' => 0];
		$success = ['code' => 1];
		/* 对 ajax和post请求判断 */
		if (!request()->isAjax() || !request()->isPost()) {
			return json($error);
		}
		/* 数据库主机 */
		$dbhost = input('post.dbhost/s', '');
		/* 数据库用户 */
		$dbuser = input('post.dbuser/s', '');
		/* 数据库密码 */
		$dbpw = input('post.dbpw/s', '');
		/* 数据库端口号 */
		$dbport = input('post.dbport/d', 0);
		/* 连接数据库 */
		$conn = mysqli_connect($dbhost, $dbuser, $dbpw, null, $dbport);
		/* 数据库连接检查 */
		if (!$conn) {
			return json($error);
		}
		return json($success);
	}
}
