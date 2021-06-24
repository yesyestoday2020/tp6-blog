<?php

/**
 * 测试文件写入检测
 */
function testwrite($d)
{
	$tfile = "test.txt";
	/* 文件打开 */
	$fp = @fopen($d . "/" . $tfile, "w");
	if (!$fp) {
		return false;
	}
	/* 文件关闭 */
	fclose($fp);
	/* 删除文件 */
	$rs = @unlink($d . "/" . $tfile);
	if ($rs) {
		return true;
	}
	return false;
}

/**
 * sql分割
 */
function sql_split($sql, $tablepre)
{
	if ($tablepre != "yzm_")
		/* str_replace() 字符串替换 */
		$sql = str_replace("yzm_", $tablepre, $sql);
	/* preg_replace — 执行一个正则表达式的搜索和替换 */
	$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;

	/* explode()分割字符串 */
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);

	foreach ($queriesarray as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach ($queries as $query) {
			$str1 = substr($query, 0, 1);
			if ($str1 != '#' && $str1 != '-')
				$ret[$num] .= $query;
		}
		$num++;
	}
	return $ret;
}

/**
 * 当前状态,以及信息提示,接收两个参数，第一个是字符串,第二个是类型
 */
function correct_span($text = '', $type = 1)
{
	$type_s = '';
	$type_p = 'success_span_p';
	if ($type == 0) {
		$type_s = 'error_span';
		$type_p = 'error_span_p';
	}
	return "<span class='correct_span {$type_s}'>&radic;</span>
			<span class='{$type_p}'> " . $text . "</span>";
}
