<?php
include '../../libs/pdo.class.php';
include '../../config.php';
$db = new lpdo($_pdo);
$table = 'sdbk_user';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_COOKIE["openid"])) {
    $openid = $_COOKIE["openid"];
    $userinfo = $db->get_one($table, array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        echo json_encode('unlogin student card');
        exit();
    }
} else {
    echo json_encode('false login');
    exit();
}

if ($userinfo['userid'] != $data['uid']) {
    echo json_encode('false req');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!is_numeric($id)) {
    $id = 1;
}

$cdt = array('id' => $id);

$act1 = $db->get_one('sdbk_activity', $cdt);

$cdt = array('aid' => $id);

$all = $db->get_rows('sdbk_activity_record', $cdt, false);

if ($act1['limit'] < count($all) && $act['limit'] != '0') {
    echo json_encode('fulled');
    exit();
}

$act = array(
    'aid' => $data['aid'],
    'uid' => $data['uid'],
    'param' => $data['param']
);

$insert = $db->insert('sdbk_activity_record', $act);

if ($insert) {
    echo json_encode('activity push success');
    exit();
} else {
    echo json_encode('activity push false');
    exit();
}

?>