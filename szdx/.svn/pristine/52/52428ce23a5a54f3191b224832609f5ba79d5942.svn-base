<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');

header('Content-Type:application/json');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if (!is_numeric($page)) {
    $page = 1;
}

include '../../libs/pdo.class.php';
include '../../config.php';
$db = new lpdo($_pdo);
$table = array('sdbk_user', 'sdbk_issue');

$startRow = ($page - 1) * 20;

$limit = 'order by `submitTime` desc limit ' . $startRow . ',20';

$cdt = array();

$list = $db->get_rows($table[1], $cdt, false, array('id', 'title', 'content', 'replied', 'submitTime', 'hidden'), $limit);

echo json_encode($list);

?>