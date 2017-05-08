<?php
header("Content-Type: application/json");
// setcookie('openid', 'ohHvIjoJeahJQ_e1svpDIv2YAlS4', time() + 36000);
if (isset($_COOKIE["openid"])) {
    include '../../libs/mysql.class.php';
    include '../../config.php';
    $Mysql = new Mysql();
    $openid = mysql_real_escape_string($_COOKIE['openid']);
    $result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
    $userinfo = mysql_fetch_assoc($result);
    header('Access-Control-Allow-Origin:*');  
    header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
    echo json_encode($userinfo);
} else {
    $send = array('err' => 'Loging failed');
    header('Access-Control-Allow-Origin:*');  
    header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
    echo json_encode($send);
}
?>