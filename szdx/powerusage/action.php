<?php
require_once '../config.php';
require_once '../libs/proxy.lib.php';
require_once '../libs/pdo.class.php';
date_default_timezone_set('Asia/Shanghai');
$db = new lpdo($_pdo);

header('Content-Type: application/json');

if (isset($_COOKIE['openid'])) {
    $openid = $_COOKIE['openid'];
    $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
    if (!$userinfo) {
        echo json_encode(array('status' => false));
        exit();
    }
} else {
    echo json_encode(array('status' => false));
    exit();
}

if ($_GET['a'] == 'bind') {

    $data = json_decode(file_get_contents('php://input'), true);
    $roominfo = $db->get_one('sdbk_room', array('building' => $data['building'], 'roomname' => $data['roomname']));

    if (!$roominfo) {
        echo json_encode(array('status' => false, 'errcode' => 1));
        exit();
    }

    $in = array(
        'openid' => $openid,
        'code' => $roominfo['code'],
        'warnpush' => (int)$data['warnpush']
    );
    if ($db->insert('sdbk_room_bind', $in)) {
        echo json_encode(array('status' => true));
        exit();
    } else {
        echo json_encode(array('status' => false));
        exit();
    }

} else if ($_GET['a'] == 'getUser') {

    if ($db->get_one('sdbk_room_bind', array('openid' => $openid))) {
        echo json_encode(array('status' => true));
        exit();
    } else {
        echo json_encode(array('status' => false));
        exit();
    }

} else if ($_GET['a'] == 'warnpush') {

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        echo json_encode(array('status' => false, 'errmsg' => '保存失败！'));
        exit();
    }
    $data['warnpush'] = ($data['warnpush']) ? 1 : 0;

    if ($db->update('sdbk_room_bind', $data, array('openid' => $openid))) {
        echo json_encode(array('status' => true));
        exit();
    } else {
        echo json_encode(array('status' => false, 'errmsg' => '保存失败！', 'data' => $data));
        exit();
    }

} else if ($_GET['a'] == 'changeBind') {

    $data = json_decode(file_get_contents('php://input'), true);
    $roominfo = $db->get_one('sdbk_room', array('building' => $data['building'], 'roomname' => $data['roomname']));

    if (!$roominfo) {
        echo json_encode(array('status' => false, 'errmsg' => '房间不存在哦！', 'errcode' => 1));
        exit();
    }

    $in = array('code' => $roominfo['code']);
    if ($db->update('sdbk_room_bind', $in, array('openid' => $openid))) {
        echo json_encode(array('status' => true));
        exit();
    } else {
        echo json_encode(array('status' => false, 'errmsg' => '服务器出错！'));
        exit();
    }

}


?>