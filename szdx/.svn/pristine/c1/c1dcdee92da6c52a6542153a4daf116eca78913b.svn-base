<?php
include '../libs/pdo.class.php';
include '../config.php';
$db = new lpdo($_pdo);
$table = 'sdbk_card';

header('Content-Type:application/json');

$studentNo = isset($_GET['studentNo']) ? (int)$_GET['studentNo'] : exit();

if (!is_numeric($studentNo)) {
    exit();
}

$cdt = array('studentNo' => $studentNo, 'isreturn' => '0');

$list = $db->get_one($table, $cdt, array('studentNo', 'studentName'));

echo json_encode($list);

?>