<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();

if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
	if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/xuanke"));
		exit();
  	}
  	$openid = $_COOKIE["openid"];
  	$result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
  	$userinfo = mysql_fetch_array($result);
  	if ($userinfo['studentNo'] == 0) {
  		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/xuanke"));
  		exit();
  	}
} else {
	header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/xuanke"));
	exit();
}

$studentNo = $userinfo['studentNo'];
$examRes = $Mysql->Selects('*', 'sdbk_xuanke1', '`studentNo` = '.$studentNo);
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>选课结果-深大百科</title>
<link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="http://www.wacxt.cn/xuanke/css/index.css" rel="stylesheet">
</head>
<body>
<div class="header">
	<div class="headimg">
		<img src="<?php echo $userinfo['headimgurl'] ?>">
	</div>
	<div class="userinfo">
		<h1><?php echo $userinfo['studentName'] ?></h1>
		<p>学号：<?php echo $userinfo['studentNo'] ?></p>
	</div>
</div>
<div class="header-bg">
	<img src="http://cdn.www.wacxt.cn/res/images/1.jpg">
</div>
<?php
	if (mysql_num_rows($examRes) == 0) {
?>
<div class="examPlan Emp">
	<p class="empty">暂无您的选课信息</p>
</div>
<?php
	} else {
		$exam = array();
		$i = 0;
		$score = 0;
		while ($examPlan = mysql_fetch_array($examRes)) {
			$exam[$i]['className'] = $examPlan['className'];
			$exam[$i]['classNo'] = $examPlan['classNo'];
			$exam[$i]['score'] = $examPlan['score'];
			$exam[$i]['req'] = $examPlan['req'];
			$score += $exam[$i]['score'];
			$i++;
		}	
?>
<a href="javascript:void(0);" class="creatImgBtn"> 共 <?php echo $score ?> 学分</a>
<div class="mainContent">
<?php
	for ($j=0; $j < count($exam); $j++) {
?>
	<div class="examPlan">
		<div class="examTime">
			<p><?php echo $exam[$j]['className'] ?></p>
		</div>
		<div class="examInfo">
			<p><i class="fa fa-tag title"> 课程号：</i><?php echo $exam[$j]['classNo'] ?></p>
			<p><i class="fa fa-clock-o title"> 学分：</i><?php echo $exam[$j]['score'] ?></p>
			<p><i class="fa fa-building-o title"> 选修必修：</i><?php echo $exam[$j]['req'] ?></p>
		</div>
	</div>
	<?php
		}
	}
	?>
</div>
<div class="footer">
	<p>数据授权：深圳大学教务部</p>
	<p>学生事务服务中心 · 诚意出品</p>
	<p>Code by Jason</p>
	<p>查询方法：进入 荔园荔事 公众号，回复“选课结果”查询</p>
	<p><img src="http://cdn.www.wacxt.cn/res/images/lyls_qrcode.jpg" width="100px"></p>
</div>
</body>
</html>