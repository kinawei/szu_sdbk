<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();

if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
	if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/book"));
		exit();
  	}
  	$openid = $_COOKIE["openid"];
  	$result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
  	$userinfo = mysql_fetch_array($result);
  	if ($userinfo['studentNo'] == 0) {
  		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/book"));
  		exit();
  	}
} else {
	header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/book"));
	exit();
}

$studentNo = $userinfo['studentNo'];
//$studentNo = 2010150094;
//$userinfo['studentName'] = "林玉堂";
//$userinfo['studentNo'] = "2010150094";
//$userinfo['headimgurl'] = "http://test.cardniu.com/suishoudai/pc/static/images/qrCode.png";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>“一书一故事”读书助学主题活动</title>
<link href="//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../exam/css/index.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript" src="js/autofull.js"></script>
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
	<img src="img/book/1.jpg">
</div>
<div class="mainContent">
    <div class="page_title">“一书一故事”读书助学主题活动</div>
    <div class="xsb">深圳大学学生部</div>
<?php
    
$stuRes = $Mysql->Selects("*", "sdbk_pk_student", "`stu_num` = ".$studentNo);
?>
    <div class="welcome">欢迎参与活动，请点击以下目录书名查看具体书本介绍以及领取。</div>
    <?php
    	$stu = array();
		$i = 0;
		while ($stuInfo = mysql_fetch_array($stuRes)) {
			$stu['id'] = $stuInfo['id'];
			$stu['stu_num'] = $stuInfo['stu_num'];
			$stu['name'] = $stuInfo['name'];
			$stu['is_book'] = $stuInfo['is_book'];
			$stu['book_name'] = $stuInfo['book_name'];
			$i++;
		}
    
		$bookRes = $Mysql->Selects('*', 'sdbk_book');
    
    	$book = array();
		$j = 0;
		while ($bookInfo = mysql_fetch_array($bookRes)) {
            ?>
    	<a href="book.php?book=<?php echo $bookInfo['id']?>" class="book_link"><?php echo ($j+1).'、'.$bookInfo['book'];?><span class="sy">（剩余<?php echo $bookInfo['num']?>本）</span></a>
    <?php
			$book[$j]['id'] = $bookInfo['id'];
			$book[$j]['book'] = $bookInfo['book'];
			$book[$j]['title'] = $bookInfo['title'];
			$book[$j]['num'] = $bookInfo['num'];
			$book[$j]['desc'] = $bookInfo['desc'];
			$j++;
		}


    ?>
    <div></div>
    </div>
<div class="footer">
	<p>学生事务服务中心 · 诚意出品</p>
</div>
</body>
</html>