<?php
/**
 *	@copyright  Copyright (c) 2015 深大百科
 *	@author     Jason <jason@zingcss.com>
 */

/** MYSQL配置 */
define('MYSQL_HOST', '127.0.0.1'); //数据库
define('MYSQL_USER', 'root'); //数据库账户
define('MYSQL_PASS', ''); //数据库密码
define('MYSQL_PORT', '3306'); //数据库端口
define('MYSQL_DB', 'sdbk'); //数据库
define('MYSQL_CHAR', 'utf8'); //数据库字符集

/** 微信APPID和APPSECRET */
define('APPID', 'wx36a4c7de498c0009'); //APPID
define('APPSECRET', 'f3f0ce18a090568f7b20f4c66fd87b13'); //APPSECRET
define('TOKEN', 'X6m7wY0uQMunyC02Xyiu7ZnMT0y2UAA6'); // RES TOKEN

/** PDO Config */
$_pdo = array();
$_pdo['dbtype'] = 'mysql';
if (!defined('SAE_MYSQL_DB')) {
	$_pdo['dbname'] = MYSQL_DB;
	$_pdo['host'] = MYSQL_HOST;
	$_pdo['port'] = 3306;
	$_pdo['username'] = MYSQL_USER;
	$_pdo['password'] = MYSQL_PASS;
} else {
	$_pdo['dbname'] = SAE_MYSQL_DB;
	$_pdo['host'] = SAE_MYSQL_HOST_M;
	$_pdo['port'] = SAE_MYSQL_PORT;
	$_pdo['username'] = SAE_MYSQL_USER;
	$_pdo['password'] = SAE_MYSQL_PASS;
}
$_pdo['charset'] = MYSQL_CHAR;

?>