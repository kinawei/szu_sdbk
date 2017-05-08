<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_admin';

header('Content-Type:application/json');

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one($table, array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit(2);
}

if ($userinfo['rank'] >= 5) {
    $action = $_GET['action'];
    if ($action == 'getadmin') {
        $list = $db->get_rows($table, array(), false, array('uid', 'username', 'rank'));
        echo json_encode($list);
    } else if ($action == 'delete') {
        $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : exit();
        if (!is_numeric($uid)) {
            exit('uid');
        }
        $cdt = array('uid' => $uid);
        $log->save('删除了管理员：'.$uid);
        $list = $db->delete($table, $cdt);
        if (is_numeric($list)) {
            echo json_encode('success');
        } else {
            echo json_encode('failed');
        }
    } else if ($action == 'resetpassword') {
        $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : exit();
        if (!is_numeric($uid)) {
            exit('uid');
        }
        $cdt = array('uid' => $uid);
        $admin = $db->get_one($table, $cdt);
        $up = array('password' => sha1('123456'.$admin['uuid']));
        $log->save('重置了管理员的密码：'.$uid);
        $list = $db->update($table, $up, $cdt);
        if (is_numeric($list)) {
            echo json_encode('success');
        } else {
            echo json_encode('failed');
        }
    } else if ($action == 'search') {
        $keyword = isset($_GET['keyword']) ? strip_tags($_GET['keyword']) : exit();
        $keyword = str_replace('\'', '', $keyword);
        $cdt = array('username' => $keyword);
        $list1 = $db->get_rows($table, $cdt, false, array('uid', 'username', 'rank'), '', 'like', '=');
        $cdt1 = array('uid' => $keyword);
        $list2 = $db->get_rows($table, $cdt1, false, array('uid', 'username', 'rank'));
        $list = array_merge($list1, $list2);
        echo json_encode($list);
    }
} else {
    exit(1);
}
















?>