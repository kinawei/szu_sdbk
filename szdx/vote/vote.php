<?php
include '../config.php';
include '../libs/mysql.class.php';
$Mysql = new Mysql();

$ua = $_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/micromessenger/i', $ua)){
	echo 'error';
    exit();
}

$id = explode(',', $_GET['id']);
$openid = $_GET['openid'];
if($openid=='' || empty($openid)){
	echo 'error';
    exit();
}
$time = time();
for ($i=0; $i < count($id); $i++) { 
	$ishave = $Mysql->Selects('*', 'sdbk_vote_record', "`openid` = '".$openid."' and `id` = ".$id[$i]);
	if (mysql_num_rows($ishave) != 0) {
		echo json_encode(array("status" => 1));
		exit;
	}
    $have = $Mysql->Selects('*', 'sdbk_user', "`openid` = '".$openid."' ");
	if (mysql_num_rows($have) == 0) {
		exit;
	}
	$res = $Mysql->Insert('sdbk_vote_record', "id,openid,time", $id[$i].",'".$openid."',".$time);
	if ($res) {
		$ballot = $Mysql->Select_Rows('*', 'sdbk_vote_record', "`id` = ".$id[$i]);
		$voteBallot = array($id[$i] => $ballot);
	}
}
echo json_encode(array("status" => 0, "ballot" => $voteBallot));
?>