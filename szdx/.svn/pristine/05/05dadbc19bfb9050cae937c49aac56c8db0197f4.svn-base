<?php
header("Content-type: application/json");
$roomcode = is_numeric($_GET['roomcode']) ? $_GET['roomcode'] : die(json_encode("false"));
$openid = htmlentities($_GET['openid']);
include '../config.php';
include '../libs/mysql.class.php';
$Mysql = new Mysql();
$resuleRows = $Mysql->Select_Rows("*", "sdbk_room_warn", "`openid` = '".$openid."' and `roomcode` = ".$roomcode);
if ($resuleRows == 0) {
	$result = $Mysql->Insert("sdbk_room_warn", "roomcode,openid", $roomcode.",'".$openid."'");
} else {
	$result = $Mysql->Delete("sdbk_room_warn", "`roomcode` = ".$roomcode." and `openid` = '".$openid."'");
}

if($result){
	echo json_encode("true");
} else {
	echo json_encode("false");
}

?>