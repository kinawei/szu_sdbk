<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="format-detection" content="telephone=no" />
<title>“好书赠你，感悟共享”读书助学主题活动</title>
    </head>
    <body>
<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();
$stuRes = $Mysql->Selects('*', 'sdbk_pk_student','is_book = 1');
while ($stuInfo = mysql_fetch_array($stuRes)) {
    //var_dump($stuInfo);
    ?>
        <div style="width: 100%;border-bottom: 1px solid #333">
<div style="float: left">学号：<?php echo $stuInfo['stu_num']?></div>
<div style="float: left;margin-left:10px;">姓名：<?php echo $stuInfo['name']?></div>
<div style="float: left;margin-left:10px;">书本：<?php echo $stuInfo['bookname']?></div>
<div style="float: left;margin-left:10px;">编号：<?php echo $stuInfo['bh']?></div>
<div style="clear: both"></div>
        </div>
<?php
}
?>
    </body>
</html>