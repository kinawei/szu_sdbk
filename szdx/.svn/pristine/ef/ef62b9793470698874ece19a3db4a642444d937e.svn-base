<?php
session_start();
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
// include '../log.class.php';
// $log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_user';

$data = json_decode(file_get_contents('php://input'), true);

$cdt = array(
    'username' => $data['username']
);

$res = $db->get_one('sdbk_admin', $cdt);

if (sha1($data['password'].$res['uuid']) != $res['password']) {
    echo json_encode('failed');
} else {
	$_SESSION['uuid'] = $res['uuid'];
	setcookie('uuid', $res['uuid'], time() + 3600);
	echo json_encode(array('status' => 'success', 'uuid' => $res['uuid']));
}
?>