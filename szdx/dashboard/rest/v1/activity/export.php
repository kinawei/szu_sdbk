<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

if (!is_numeric($id)) {
    exit();
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=export-'.time().'.xls');
header('Pragma: no-cache');
header('Expires: 0');

$dataRaw = $db->query('select `sdbk_user`.`studentName`,`sdbk_user`.`studentNo`,`sdbk_user`.`sex`,`sdbk_user`.`org`,`sdbk_activity_record`.`param` from `sdbk_activity_record` left join `sdbk_user` on `sdbk_activity_record`.`uid` = `sdbk_user`.`userid` where `sdbk_activity_record`.`aid` = '.$id);

if (count($dataRaw) === 0) {
    echo '空';
}


for ($i = 0; $i < count($dataRaw); $i++) {
    $dataRaw[$i]['param'] = json_decode($dataRaw[$i]['param'], true);
}

$excelTitle = array();
$excelData = array();

for ($i = 0; $i < count($dataRaw); $i++) {
    if ($i == 0) {
        foreach ($dataRaw[0] as $key => $value) {
            if ($key == 'param') {
                foreach ($value as $key1 => $value1) {
                    array_push($excelTitle, $value1['name']);
                }
            } else {
                array_push($excelTitle, $key);
            }
        }
    }
    $excelData[$i] = array();
    foreach ($dataRaw[$i] as $key => $value) {
        if ($key == 'param') {
            foreach ($value as $key1 => $value1) {
                array_push($excelData[$i], $value1['value']);
            }
        } else {
            array_push($excelData[$i], $value);
        }
    }
}

$log->save('导出了ID为：'.$id.'的活动的报名数据');

echo iconv('utf-8', 'gbk', implode("\t", $excelTitle)), "\n";

foreach ($excelData as $value) {
    echo iconv('utf-8', 'gbk', implode("\t", $value)), "\n";
}

?>