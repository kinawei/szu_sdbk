<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();

$uid = $_POST['uid'];
$bid = $_POST['bid'];
$sname = $_POST['sname'];
//$uid = 2010150094;
//$bid = 8;
//$sname = '林玉堂';
$stuRes = $Mysql->Selects('*', 'sdbk_pk_student', '`stu_num` = '.$uid);

if(mysql_num_rows($stuRes) == 0){
    //echo '不好意思，你没有领书的资格';exit();
    $bookRes = $Mysql->Selects('*', 'sdbk_book', '`id` = '.$bid);
    
    	$book = array();
		$j = 0;

		while ($bookInfo = mysql_fetch_array($bookRes)) {
			$book['id'] = $bookInfo['id'];
			$book['book'] = $bookInfo['book'];
			$book['title'] = $bookInfo['title'];
			$book['num'] = $bookInfo['num'];
			$book['desc'] = $bookInfo['desc'];
			$book['no'] = $bookInfo['no'];
			$j++;
		}
    if($book['num'] == 0){
        echo '《'.$book['book'].'》这本书已经被领完，请选择其他书~';
    }else{
        $book['num']--;
    $b_up = $Mysql->Update('sdbk_book','`num`='.$book['num'],'`id` = '.$bid);
        $bookname = $book['book'];
        $Mysql->Insert('sdbk_pk_student','stu_num,name,is_book,bookname,bh', $uid.",'".$sname."',1,'".$bookname."','".$book['no']."'");
        echo "你已选取书本《".$book['book']."》（编号".$book['no']."），请记住编号，并于12月25日前到学生事务服务中心9号窗口领取书本。";
    }
    
    
}else{
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

$bookRes = $Mysql->Selects('*', 'sdbk_book', '`id` = '.$bid);
    
    	$book = array();
		$j = 0;

		while ($bookInfo = mysql_fetch_array($bookRes)) {
			$book['id'] = $bookInfo['id'];
			$book['book'] = $bookInfo['book'];
			$book['title'] = $bookInfo['title'];
			$book['num'] = $bookInfo['num'];
			$book['desc'] = $bookInfo['desc'];
			$book['no'] = $bookInfo['no'];
			$j++;
		}
if($book['num'] == 0){
	echo '《'.$book['book'].'》这本书已经被领完，请选择其他书~';
}else if($stu['is_book'] == 1){
    echo '您已经领过书了！';
}else{
	$book['num']--;
$b_up = $Mysql->Update('sdbk_book','`num`='.$book['num'],'`id` = '.$bid);
    $bookname = $book['book'];
    $Mysql->Update('sdbk_pk_student',"`is_book`=1 ,bookname = '{$bookname}',bh = '{$book['no']}'",'`stu_num` = '.$uid);
    echo "你已选取书本《".$book['book']."》（编号".$book['no']."），请记住编号，并于12月25日前到学生事务服务中心9号窗口领取书本。";
}
}

