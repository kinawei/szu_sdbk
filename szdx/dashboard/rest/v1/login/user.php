<?php
if (!isset($_COOKIE['uuid']) || strlen($_COOKIE['uuid']) != 36) {
	echo json_encode('failed');
	exit();
}
header('Content-Type:application/json');

include '../../../../libs/pdo.class.php';
include '../../../../config.php';
$db = new lpdo($_pdo);
$table = 'sdbk_admin';


$cdt = array('uuid' => $_COOKIE['uuid']);

$list = $db->get_one($table, $cdt, array('uid', 'uuid', 'username', 'rank'));

echo json_encode($list);
?>