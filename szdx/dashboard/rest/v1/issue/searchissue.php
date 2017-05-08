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

$keyword = isset($_GET['keyword']) ? strip_tags($_GET['keyword']) : exit();

$keyword = str_replace('\'', '', $keyword);

$limit = 'order by `submitTime` desc';

$cdt = array('title' => $keyword, 'content' => $keyword, 'reply' => $keyword);

$list1 = $db->get_rows($table[1], $cdt, false, array('id', 'title', 'userid'), $limit, 'like', 'OR');

$cdt1 = array('id' => $keyword);

$list2 = $db->get_rows($table[1], $cdt1, false, array('id', 'title', 'userid'));

$list = array_merge($list1, $list2);

for ($i = 0; $i < count($list); $i++) {
    $co = array('userid' => $list[$i]['userid']);
    $nickname = $db->get_one($table[0], $co, array('nickname'));
    $list[$i]['user'] = $nickname['nickname'];
}

$output = array('status' => '', 'data' => $list);

if (count($list) == 0) {
    $output['status'] = 'empty';
} else {
    $output['status'] = 'success';
}

echo json_encode($output);
?>