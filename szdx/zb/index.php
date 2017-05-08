<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();
$thisPageUri = 'http://210.39.2.134/test/zb/index.php';

if (isset($_COOKIE["icAccount"])) {
  	$icAccount = $_COOKIE["icAccount"];
  	$result = $Mysql->Selects('*', 'sdbk_user', ' `icAccount` = "'.$icAccount.'"');
  	$userinfo = mysql_fetch_array($result);
} else if (isset($_GET["ticket"])){
	$url = "http://210.39.2.134/test/getuserinfo.php?ticket=".$_GET["ticket"];
	$casRes = json_decode(file_get_contents($url), true);
	if ($casRes['data']['icAccount'] != null) {
		$icAccount = $casRes['data']['icAccount'];
		$org = $casRes['data']['org'];
		$personalId = $casRes['data']['personalId'];
		$rankName = $casRes['data']['rankName'];
		$sex = $casRes['data']['sex'];
		$studentName = $casRes['data']['studentName'];
		$studentNo = $casRes['data']['studentNo'];
        $ishave = $Mysql->Select_Rows('*', 'sdbk_user', ' `icAccount` = '.$icAccount);
		if ($ishave) {
			$status = 2;
            //echo $ishave;
		} else {
			$done = $Mysql->Insert('sdbk_user', "`icAccount`,`org`,`personalId`,`rankName`,`sex`,`studentName`,`studentNo`,`time`", $icAccount.",'".$org."','".$personalId."','".$rankName."','".$sex."','".$studentName."',".$studentNo.",".time());
            if ($done) {
				setcookie('icAccount', $icAccount, time() + 3600);
				header('Location: '.$thisPageUri);
				$status = 1;
				exit();
			} else {
				$status = 0;
			}
		}
	} else {
		$status = 0;
	}
} else {
	header("Location: http://210.39.2.134/test/caslogin.php");
	exit();
}

print_r($userinfo);
exit();

session_start();
$srcstr = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
mt_srand();
$access_token = "";
for ($i = 0; $i < 32; $i++) {
	$access_token .= $srcstr[mt_rand(0, 61)];
}
$_SESSION['access_token'] = $access_token;

//LOGIN HERE

$userinfo = array('studentName' => '陈俊毅', 'sex' => '男', 'studentNo' => 2014130355, 'personalId' => '350205199602113015' , 'org' =>  '深圳大学/信息工程学院/本科生/2014级');
$birthday['year'] = substr($userinfo['personalId'], 6, 4);
$birthday['month'] = substr($userinfo['personalId'], 10, 2);
$birthday['day'] = substr($userinfo['personalId'], 12, 2);
$college = explode('/', ($userinfo['org']));

?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>深圳大学应征青年征兵意愿登记表</title>
<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet">
</head>
<body>
<header>
	<div class="container">
		<h5>深圳大学应征青年</h5>
		<h3>征兵意愿登记表</h3>
	</div>
</header>
<div class="container">
	<form class="form-horizontal" action="do.php?access_token=<?php echo $access_token ?>" method="POST">
		<div class="form-group col-sm-6">
			<label class="col-sm-4 col-xs-5 control-label">姓名</label>
			<div class="col-sm-8 col-xs-7">
				<p class="form-control-static"><?php echo $userinfo['studentName'] ?></p>
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label class="col-sm-4 col-xs-5 control-label">学号</label>
			<div class="col-sm-8 col-xs-7">
				<p class="form-control-static"><?php echo $userinfo['studentNo'] ?></p>
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label class="col-sm-4 col-xs-5 control-label">性别</label>
			<div class="col-sm-8 col-xs-7">
				<p class="form-control-static"><?php echo $userinfo['sex'] ?></p>
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label class="col-sm-4 col-xs-5 control-label">出生日期</label>
			<div class="col-sm-8 col-xs-7">
				<p class="form-control-static"><?php echo implode('.', $birthday) ?></p>
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label class="col-sm-4 col-xs-5 control-label">学院</label>
			<div class="col-sm-8 col-xs-7">
				<p class="form-control-static"><?php echo $college[1] ?></p>
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-mz" class="col-sm-4 col-xs-5 control-label">民族</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-mz" placeholder="">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-zzmm" class="col-sm-4 col-xs-5 control-label">政治面貌</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-zzmm" placeholder="团员、党员、群众">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-phone" class="col-sm-4 col-xs-5 control-label">联系电话</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-phone" placeholder="长号或短号">
			</div>
		</div>
		<div class="form-group">
			<label for="input-pre" class="col-sm-3 control-label">入学前户口所在地</label>
			<div class="col-sm-8">
				<input class="form-control" id="input-pre" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="input-now" class="col-sm-3 control-label">现户口所在地</label>
			<div class="col-sm-8">
				<input class="form-control" id="input-now" placeholder="">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-left" class="col-sm-4 col-xs-5 control-label">左眼视力</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-left" placeholder="">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-right" class="col-sm-4 col-xs-5 control-label">右眼视力</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-right" placeholder="">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-height" class="col-sm-4 col-xs-5 control-label">身高</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-height" placeholder="">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<label for="input-weight" class="col-sm-4 col-xs-5 control-label">体重</label>
			<div class="col-sm-8 col-xs-7">
				<input class="form-control" id="input-weight" placeholder="">
			</div>
		</div>
		<div class="form-group">
			<label for="input-bpre" class="col-sm-2 control-label">血压</label>
			<div class="col-sm-9">
				<input class="form-control" id="input-bpre" placeholder="">
			</div>
		</div>
		<button type="button" class="btn btn-primary" onclick="subForm()">我已确认以上信息，并提交</button>
	</form>
</div>
<footer>
	<p>Code by Jason</p>
</footer>
<div class="showtips"></div>
<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<script src="zb.js"></script>
</body>
</html>