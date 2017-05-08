<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
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
    exit();
}

$cdt = array('id' => $id);

$log->save('删除了事务：'.json_encode($cdt));

$list = $db->delete($table[1], $cdt);

if (is_numeric($list)) {
    echo json_encode('success');
} else {
    echo json_encode('failed');
}


?>