<?php

header('Content-Type:application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!is_numeric($id)) {
    $id = 1;
}

include '../../libs/pdo.class.php';
include '../../config.php';
$db = new lpdo($_pdo);
$table = array('sdbk_user', 'sdbk_issue');

$cdt = array('id' => $id);

$issue = $db->get_one($table[1], $cdt);

$cdt = array('userid' => $issue['userid']);

$userinfo = $db->get_one($table[0], $cdt);

$user = array(
	'nickname' => $userinfo['nickname'],
	'headimgurl' => $userinfo['headimgurl']
);

$merge = array_merge($issue, $user);

// var_dump($issue);

echo json_encode($merge);

?>