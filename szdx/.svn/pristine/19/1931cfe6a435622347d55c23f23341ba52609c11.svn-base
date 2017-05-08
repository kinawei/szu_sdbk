<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit();
}

$activity = array(
    'name' => $data['name'],
    'startTime' => $data['startTime'],
    'endTime' => $data['endTime'],
    'param' => $data['parameters'],
    'limit' => $data['limit']
);

$done = $db->insert('sdbk_activity', $activity);

if (is_numeric($done)) {
    $cdt = array('name' => $data['name']);
    $list = $db->get_one('sdbk_activity', $cdt, array('id'));
    $log->save('添加活动：'.$data['name']);
    echo json_encode(array('status' => 'success', 'id' => $list['id']));
} else {
    echo json_encode('false');
}

?>