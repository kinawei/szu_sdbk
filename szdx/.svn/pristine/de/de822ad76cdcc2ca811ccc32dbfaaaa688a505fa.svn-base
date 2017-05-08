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
$book_id = $_GET['book'];
//$book_id = 1;
//$userinfo['studentName'] = '林玉堂';
//$userinfo['studentNo'] = "2010150094";
//$userinfo['headimgurl'] = "http://test.cardniu.com/suishoudai/pc/static/images/qrCode.png";
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
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
    
		$stuRes = $Mysql->Selects('*', 'sdbk_pk_student', '`stu_num`='.$studentNo);

    	$stu = array();
		$stu['is_book'] = 0;
		$i = 0;
		while ($stuInfo = mysql_fetch_array($stuRes)) {
			$stu['id'] = $stuInfo['id'];
			$stu['stu_num'] = $stuInfo['stu_num'];
			$stu['name'] = $stuInfo['name'];
			$stu['is_book'] = $stuInfo['is_book'];
			$stu['book_name'] = $stuInfo['book_name'];
			$i++;
		}
//var_dump($stu);
    
$bookRes = $Mysql->Selects('*', 'sdbk_book', '`id` = '.$book_id);
    
    	$book = array();
		$j = 0;
		while ($bookInfo = mysql_fetch_array($bookRes)) {
			$book['id'] = $bookInfo['id'];
			$book['book'] = $bookInfo['book'];
			$book['title'] = $bookInfo['title'];
			$book['num'] = $bookInfo['num'];
			$book['desc'] = $bookInfo['desc'];
			$j++;
		}
//var_dump($book);
    ?>
    <img class="book_pic" src="book/<?php echo $book['id']?>.jpg" />
    <span style="margin-left: 10px">剩余数量<span style="color:red"><?php echo $book['num']?></span>本</span>
    <div class="b_title"><?php echo $book['title']?></div>
    <div ><?php echo str_replace(PHP_EOL, '<br>', $book['desc'])?></div>
    <div class="btn_get" id="btn_get">点击领取</div>
    
    <?php


    ?>
    <div></div>
    </div>
<div class="footer">
	<p>学生事务服务中心 · 诚意出品</p>
</div>
    <script type="text/javascript" src="js/jquery-1.11.3.min.js" ></script>
    <script>
        $('#btn_get').click(function(){
            var confirm = window.confirm("是否确定选此书，一旦选定，不可撤销");
            if(confirm == true){
                if(<?php echo $book['num']?> == 0){
                    alert("《<?php echo $book['book']?>》这本书已经被领完，请选择其他书~");
                    return;
                }
                if(<?php echo $stu['is_book']?> == 1){
                    alert("您已经领过书了！");
                    return;
                }
                console.log('aaaaa');
                $.ajax({
                    type: "POST",
                    url: "api.php",
                    data:{
                        uid: <?php echo $studentNo ?>,
                        bid: <?php echo $book['id'] ?>,
                        sname: "<?php echo $userinfo['studentName'] ?>"
                    },
                    success: function(res){
                        alert(res);
                    }
                });
            }
            
        });
    </script>
</body>
</html>