<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();

if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
	if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
		$callback = array('code' => 1);
		echo json_encode($callback);
		exit();
  	}
  	$openid = $_COOKIE["openid"];
  	$result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
  	$userinfo = mysql_fetch_array($result);
  	if ($userinfo['studentNo'] == 0) {
  		$callback = array('code' => 1);
		echo json_encode($callback);
  		exit();
  	}
} else {
	$callback = array('code' => 1);
		echo json_encode($callback);
	exit();
}

$id = $userinfo['userid'];
$text = dhtmlspecialchars($_GET['text']);
$time = time();

$result = $Mysql->Insert('sdbk_timemachine', "`userid`,`text`,`time`", $id.",'".$text."',".$time);

if ($result) {
	$callback = array('code' => 0);
	echo json_encode($callback);
}

function dhtmlspecialchars($string, $flags = null) {  
    if(is_array($string)) {  
        foreach($string as $key => $val) {  
            $string[$key] = dhtmlspecialchars($val, $flags);  
        }  
    } else {  
        if($flags === null) {  
            $string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);  
            if(strpos($string, '&amp;#') !== false) {  //过滤掉类似&#x5FD7的16进制的html字符  
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);  
            }  
        } else {  
            if(PHP_VERSION < '5.4.0') {  
                $string = htmlspecialchars($string, $flags);  
            } else {  
                if(strtolower(CHARSET) == 'utf-8') {  
                    $charset = 'UTF-8';  
                } else {  
                    $charset = 'ISO-8859-1';  
                }  
                $string = htmlspecialchars($string, $flags, $charset);  
            }  
        }  
    }  
    return $string;  
}
?>