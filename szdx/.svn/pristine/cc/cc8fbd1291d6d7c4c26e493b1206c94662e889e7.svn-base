<?php
require_once '../libs/pdo.class.php';
require_once '../config.php';
$db = new lpdo($_pdo);

header('Content-Type:application/json');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if (!is_numeric($page)) {
    $page = 1;
}

$startRow = ($page - 1) * 20;
$limit = 'order by `fetchtime` desc limit ' . $startRow . ',20';

$cdt = array('title' => str_replace('\'', '', $_GET['keyword']));
$list = $db->get_rows('sdbk_board', $cdt, false, array(), $limit, 'like');

echo json_encode($list);
?>