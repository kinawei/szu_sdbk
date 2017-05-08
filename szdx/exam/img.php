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

$studentNo = $userinfo['studentNo'];
$examRes = $Mysql->Selects('*', 'sdbk_exam', '`studentNo` = '.$studentNo);


$width = 640;
if (mysql_num_rows($examRes) <= 4) {
	$height = 190 * mysql_num_rows($examRes) + 430;
} else {
	$height = 190 * mysql_num_rows($examRes) + 410;
}

$image = imagecreate($width, $height);

$backColor = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
$fontTitleColor = imagecolorallocate($image, 64, 142, 192);
$fontColor = imagecolorallocate($image, 22, 22, 22);
$lineColor = imagecolorallocate($image, 222, 222, 222);
$footerColor = imagecolorallocate($image, 244, 87, 87);
$footerColor2 = imagecolorallocate($image, 200, 200, 200);

$font_file = "font/shsn.ttf";//SAE_Font_Hei

imagettftext($image, 16, 0, 20, 240, $fontColor, $font_file, '姓名：'.$userinfo['studentName'].'      学号：'.$userinfo['studentNo']);

imageline($image, 10, 260, 630, 260, $lineColor);

$paddingTop = 300;


$exam = array();
$i = 0;
while ($examPlan = mysql_fetch_array($examRes)) {
	$exam[$i]['className'] = $examPlan['className'];
	$exam[$i]['classNo'] = $examPlan['classNo'];
	$exam[$i]['examTime'] = $examPlan['examTime'];
	$exam[$i]['examLocation'] = $examPlan['examLocation'];
	$exam[$i]['examLocationIn'] = $examPlan['examLocationIn'];
	$i++;
}
$n = count($exam);
for($a = 0; $a < $n-1; $a++){
	for($k = 0; $k < $n-$a-1; $k++){
		$m = explode('月', $exam[$k]['examTime']);
		$m = (int)substr($m[0], -2);
		$day = explode('日', $exam[$k]['examTime']);
		$day = (int)substr($day[0], -2);
		$h = explode('时', $exam[$k]['examTime']);
		$h = (int)substr($h[0], -2);
		$m1 = explode('月', $exam[$k+1]['examTime']);
		$m1 = (int)substr($m1[0], -2);
		$day1 = explode('日', $exam[$k+1]['examTime']);
		$day1 = (int)substr($day1[0], -2);
		$h1 = explode('时', $exam[$k+1]['examTime']);
		$h1 = (int)substr($h1[0], -2);
		if($m > $m1){
			$kong = $exam[$k+1];
			$exam[$k+1] = $exam[$k];
			$exam[$k] = $kong;  
		} elseif ($m == $m1) {
			if ($day > $day1) {
				$kong = $exam[$k+1];
				$exam[$k+1] = $exam[$k];
				$exam[$k] = $kong; 
			} elseif ($day == $day1) {
				if ($h > $h1) {
					$kong = $exam[$k+1];
					$exam[$k+1] = $exam[$k];
					$exam[$k] = $kong;
				}
			}
		}
	}
}
for ($j=0; $j < count($exam); $j++) {
	imagettftext($image, 20, 0, 20, $paddingTop, $fontTitleColor, $font_file, $exam[$j]['classNo']);
	$paddingTop += 40;
	imagettftext($image, 20, 0, 20, $paddingTop, $fontTitleColor, $font_file, $exam[$j]['className']);
	$paddingTop += 40;
	imagettftext($image, 18, 0, 20, $paddingTop, $fontColor, $font_file, '考试时间：'.$exam[$j]['examTime']);
	$paddingTop += 40;
	imagettftext($image, 18, 0, 20, $paddingTop, $fontColor, $font_file, '考试地点：'.$exam[$j]['examLocation'].'（'.$exam[$j]['examLocationIn'].'）');
	$paddingTop += 20;
	imageline($image, 10, $paddingTop, 630, $paddingTop, $lineColor);
	$paddingTop += 40;
}

imagettftext($image, 18, 0, 70, $paddingTop + 20, $footerColor, $font_file, '查询期末考试安排，请搜索公众号“深大考试君”');

imagettftext($image, 18, 0, 160, $paddingTop + 70, $footerColor, $font_file, '回复“考试安排”即可查询。');

imagettftext($image, 18, 0, 160, $paddingTop + 120, $footerColor2, $font_file, '深圳大学学生事务服务中心');

$headerImg = imagecreatefrompng('image/examHeader.png');

imagecopymerge($image, $headerImg, 0, 0, 0, 0, 640, 200, 100);

header("Content-Type: image/png");

imagepng($image);
?>