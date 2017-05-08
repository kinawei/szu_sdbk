<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
header('Access-Control-Allow-Headers:x-requested-with,content-type');

header('Content-Type:application/json');

include '../../libs/pdo.class.php';
include '../../config.php';
$db = new lpdo($_pdo);
$table = array('sdbk_user', 'sdbk_issue');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$keyword = isset($_GET['keyword']) ? strip_tags($_GET['keyword']) : exit();

$keyword = str_replace('\'', '', $keyword);

if (!is_numeric($page)) {
    $page = 1;
}

$startRow = ($page - 1) * 20;

$limit = 'order by `submitTime` desc limit ' . $startRow . ',20';

$cdt = array('title' => $keyword, 'content' => $keyword);

$list = $db->get_rows($table[1], $cdt, false, array('id', 'title', 'content', 'replied', 'submitTime', 'hidden'), $limit, 'like', 'OR');

foreach ($list as $index => $value) {
    if ($value['hidden'] == '1') {
        unset($list[$index]);
    }
}

echo json_encode(array_slice($list, 0));

?>