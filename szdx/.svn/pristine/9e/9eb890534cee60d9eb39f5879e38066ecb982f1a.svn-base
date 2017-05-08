<?php
if (!isset($_COOKIE['uuid']) || strlen($_COOKIE['uuid']) != 36) {
	echo json_encode('failed');
	exit();
}
header('Content-Type:application/json');

include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_admin';

$data = json_decode(file_get_contents('php://input'), true);

$cdt = array('uuid' => $_COOKIE['uuid']);

$res = $db->get_one('sdbk_admin', $cdt);

if (sha1($data['oldpass'].$res['uuid']) != $res['password']) {
    echo json_encode('passwrong');
    exit();
}

$pass = array('password' => sha1($data['newpass'].$res['uuid']));

$update = $db->update('sdbk_admin', $pass, $cdt);

if (is_numeric($update)) {
	$log->save('修改了密码');
    echo json_encode('success');
} else {
    echo json_encode('failed');
}
?>