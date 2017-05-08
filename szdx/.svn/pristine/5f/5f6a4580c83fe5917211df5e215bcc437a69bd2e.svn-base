<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
$db = new lpdo($_pdo);
$table = array('sdbk_user', 'sdbk_issue');

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit();
}

header('Content-Type:application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!is_numeric($id)) {
    $id = 1;
}

$cdt = array('id' => $id);

$list = $db->get_one($table[1], $cdt, array('id', 'title', 'content', 'userid', 'reply', 'responder'));

$cdt = array('userid' => $list['userid']);

$userinfo = $db->get_one($table[0], $cdt, array('studentName', 'studentNo', 'org', 'phone'));

$list = array_merge($list, $userinfo);

echo json_encode($list);
?>