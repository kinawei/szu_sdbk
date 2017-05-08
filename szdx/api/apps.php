<?php
header("Content-Type: application/json");
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();
if (isset($_GET['type']) && $_GET['type'] == 'thirdpart') {
    $result = $Mysql->Selects('*', 'sdbk_apps', ' `thirdpart` = 1 and `available` = 1 ORDER BY `rank` ASC');
} else {
    $result = $Mysql->Selects('*', 'sdbk_apps', ' `thirdpart` = 0 ORDER BY `rank` ASC');
}
$apps = array();
$i = 0;
while ($app = mysql_fetch_assoc($result)) {
    $apps[$i] = $app;
    $apps[$i]['id'] = (int)$apps[$i]['id'];
    $apps[$i]['rank'] = (int)$apps[$i]['rank'];
    $apps[$i]['available'] = (boolean)$apps[$i]['available'];
    $i++;
};
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
echo json_encode($apps);
?>