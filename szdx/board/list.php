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

if (!isset($_GET['type']) || $_GET['type'] == 'all') {
    $cdt = array('fixed' => '0');
    $list = $db->get_rows('sdbk_board', $cdt, false, array(), $limit);
    $fixedList = $db->get_rows('sdbk_board', array('fixed' => '1'), false, array(), $limit);
} else {
    $cdt = array('fixed' => '0', 'type' => str_replace('\'', '', $_GET['type']));
    $list = $db->get_rows('sdbk_board', $cdt, false, array(), $limit);
    $fixedList = array();
}

echo json_encode(array_merge($fixedList, $list));
?>