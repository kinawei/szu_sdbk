<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();

if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
	if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/exam"));
		exit();
  	}
  	$openid = $_COOKIE["openid"];
  	$result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
  	$userinfo = mysql_fetch_array($result);
  	if ($userinfo['studentNo'] == 0) {
  		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/exam"));
  		exit();
  	}
} else {
	header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/exam"));
	exit();
}
require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1256894796).'" width="0" height="0"/>'
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title><?php echo $userinfo['studentName'] ?>的考试信息-深大百科</title>
<link href="http://cdn.www.wacxt.cn/res/css/common.min.css" rel="stylesheet">
<style type="text/css">
	.loading {
		position: absolute;
		top: 30px;
		left: 0;
		z-index: 1;
	}
	.image {
		position: absolute;
		top: 30px;
		left: 0;
		z-index: 100;
	}
	h1 {
		font-size: 18px;
		line-height: 30px;
		text-align: center;
		color: #408ec0;
	}
</style>
</head>
<body>
<h1>长按下面的图片保存到手机</h1>
<img src="img.php" width="100%" class="image">
<div class="loading">
	图片生成中...
</div>
</body>
</html>