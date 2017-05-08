<?php

header('Content-Type:application/json');

include '../../libs/pdo.class.php';
include '../../config.php';
$db = new lpdo($_pdo);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!is_numeric($id)) {
    $id = 1;
}

if (isset($_COOKIE["openid"])) {
    $openid = $_COOKIE["openid"];
    $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        echo json_encode('unlogin student card');
        exit();
    }
} else {
    echo json_encode('false login');
    exit();
}

$cdt = array('aid' => $id, 'uid' => $userinfo['userid']);

$is = $db->get_rows('sdbk_activity_record', $cdt);

$cdt = array('id' => $id);

$act = $db->get_one('sdbk_activity', $cdt);

// $act['param'] = json_decode($act['param'], true);

$cdt = array('aid' => $id);

$all = $db->get_rows('sdbk_activity_record', $cdt);

if ($act['limit'] <= count($all) && $act['limit'] != '0') {
	$act['fulled'] = 'yes';
} else {
	$act['fulled'] = 'no';
}

if (count($is) > 0) {
	$act['is'] = 'yes';
}

echo json_encode($act);

?>