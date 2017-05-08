<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();
$thisPageUri = 'http://'.$_SERVER['HTTP_HOST'].'/passport/test.php';

header("Content-Type:text/html; charset=utf-8");

if (isset($_GET['state'])) {
    switch ($_GET['state']) {
        case 'checkuser':
        {
            if (isset($_GET['code'])) {
                $code = $_GET['code'];
                $json = json_decode(http_get('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code'), true);
                $openid = $json['openid'];
                $result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
                if (mysql_num_rows($result) == 0) {
                    header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_userinfo&state=login#wechat_redirect');
                }
                $userinfo = mysql_fetch_array($result);
            } else {
                header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_base&state=checkuser#wechat_redirect');
            }
            break;
        }
        case 'login':
        {
            if (isset($_GET['code'])) {
                $code = $_GET['code'];
                $json = json_decode(http_get('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code'),true);
                $openid = $json['openid'];
                $access_token = $json['access_token'];
                $userinfo = json_decode(http_get('https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN'),true);
                if (isset($userinfo['errcode'])) {
                    echo $userinfo['errcode'];
                    exit;
                }
            } else {
                echo "2";
            }
            break;
        }
    }
} else {
    header('Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.$thisPageUri.'&response_type=code&scope=snsapi_base&state=checkuser#wechat_redirect');
}

function http_get($url){
    $oCurl = curl_init();
    if(stripos($url,"https://") !== FALSE) {
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"]) == 200) {
        return $sContent;
    } else {
        return false;
    }
}

print_r($done);
print_r($userinfo);
?>