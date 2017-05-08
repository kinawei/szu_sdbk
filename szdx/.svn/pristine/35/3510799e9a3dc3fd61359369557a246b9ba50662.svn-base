<?php
ini_set("max_execution_time", 3600);

include '../../../libs/pdo.class.php';
include '../../../config.php';
$db = new lpdo($_pdo);

$userlist = $db->get_rows('sdbk_user_b');

foreach ($userlist as $value) {
	echo file_get_contents('http://szdx.sinaapp.com/dashboard/rest/v1/updateuserinfo.php?openid='.$value['openid']);
}

?>