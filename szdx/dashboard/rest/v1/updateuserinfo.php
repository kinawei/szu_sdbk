<?php

include '../../../libs/pdo.class.php';
include '../../../config.php';
include 'log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$mmc = new Memcache;
$ret = $mmc->connect();

header('Content-Type:application/json');

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit(2);
}

$openid = $_GET['openid'];

$atpackage = json_decode($mmc->get('AccessToken'), true);

$access_token = $atpackage['access_token'];

$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

$newinfo = json_decode(file_get_contents($url), true);

if (isset($newinfo['errcode']) && $newinfo['errcode'] == '40001') {
	$mmc->set('AccessToken', '');
	$mmc->set('ticket', '');
	file_get_contents('http://szdx.sinaapp.com/api/jssdk.php');
	$atpackage = json_decode($mmc->get('AccessToken'), true);
	$access_token = $atpackage['access_token'];
	$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
	$newinfo = json_decode(file_get_contents($url), true);
}

	$issue = array(
    'nickname' => $newinfo['nickname'],
    'headimgurl' => $newinfo['headimgurl'],
    'city' => $newinfo['city'],
    'province' => $newinfo['province'],
    'country' => $newinfo['country']
);

$cdt = array('openid' => $openid);

$update = $db->update('sdbk_user_b', $issue, $cdt);

if (is_numeric($update)) {
	echo $openid.':'.$update.'|';
} else {
	echo json_encode($newinfo);
}


?>