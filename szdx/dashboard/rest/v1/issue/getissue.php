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

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if (!is_numeric($page)) {
    $page = 1;
}

if (!isset($_GET['type'])) {
    exit();
}

$startRow = ($page - 1) * 20;

$limit = 'order by id desc limit ' . $startRow . ',20';

if ($_GET['type'] == 0) {
    $cdt = array();
} else if ($_GET['type'] == 1) {
    $cdt = array('replied' => '0');
} else if ($_GET['type'] == 2) {
    $cdt = array('replied' => '1');
} else {
    exit();
}

$list = $db->get_rows($table[1], $cdt, false, array('id', 'title', 'userid'), $limit);

for ($i = 0; $i < count($list); $i++) {
    $co = array('userid' => $list[$i]['userid']);
    $nickname = $db->get_one($table[0], $co, array('nickname'));
    $list[$i]['user'] = $nickname['nickname'];
}

echo json_encode($list);
?>