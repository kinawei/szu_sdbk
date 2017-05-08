<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_card';
$table_user = 'sdbk_user';

header('Content-Type:application/json');

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit('GG');
} else {
    exit(2);
}

if ($userinfo['rank'] >= 5) {

    $limit = 'order by time desc limit 0,100';

    $list = $db->get_rows('sdbk_log', array(), false, array(), $limit);

    echo json_encode($list);

}
?>