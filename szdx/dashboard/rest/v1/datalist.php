<?php
include '../../../libs/pdo.class.php';
include '../../../config.php';
//include 'log.class.php';
//$log = new Log($_pdo);
$db = new lpdo($_pdo);

$output = array(
    'usercount' => 0,
    'appcount' => 0,
    'issuecount' => 0,
    'feewarncount' => 0
);

$list = $db->query('SELECT COUNT(`userid`) FROM sdbk_user');
$output['usercount'] = $list[0]['COUNT(`userid`)'];

$list = $db->query('SELECT COUNT(*) FROM sdbk_apps');
$output['appcount'] = $list[0]['COUNT(*)'];

$list = $db->query('SELECT COUNT(*) FROM sdbk_issue');
$output['issuecount'] = $list[0]['COUNT(*)'];

$list = $db->query('SELECT COUNT(*) FROM sdbk_room_bind');
$output['feewarncount'] = $list[0]['COUNT(*)'];

echo json_encode($output);


?>