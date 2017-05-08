<?php
include '../config.php';
require_once "../libs/jssdk.php";
if (isset($_POST['diao']) && $_POST['diao']="dajskhfdgjkbsvcanssmdnfkasndlk") {
    $jssdk = new JSSDK(APPID, APPSECRET);

    $access_token = $jssdk->getAccessToken();

    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;

    $json = $_POST['package'];
    $response1 = httppost($url, $json);

    $json1 = json_decode($json, true);
    $json1['touser'] = 'ohHvIjoJeahJQ_e1svpDIv2YAlS4';
    $json1 = json_encode($json1);
    $response = httppost($url, $json1);

    echo json_encode($response1).'+'.json_encode($response).'+'.$url;
}

function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

function httppost($url, $data) {
    $go = curl_init();
    curl_setopt($go, CURLOPT_URL, $url);
    curl_setopt($go, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($go, CURLOPT_MAXREDIRS, 30);
    curl_setopt($go, CURLOPT_HEADER, 0);
    curl_setopt($go, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($go, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($go, CURLOPT_TIMEOUT, 30);
    curl_setopt($go, CURLOPT_POST, 1);
    curl_setopt($go, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($go);
    return json_decode($res, true);
}
?>