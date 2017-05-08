<?php
require_once '../config.php';
require_once '../libs/pdo.class.php';
$db = new lpdo($_pdo);
// 用户认证
if (isset($_COOKIE['openid'])) {
    $openid = $_COOKIE['openid'];
    $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/missyou/"));
        exit();
    }
} else {
    header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/missyou/"));
    exit();
}
header('Content-Type: text/html; charset:utf-8');
if (!$db->get_one('sdbk_dorm_new', array('studentName' => $userinfo['studentName'], 'studentNo' => $userinfo['studentNo']))) {
    echo '仅限2016级新生使用';
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
        <title>觅室友 MissU - 深大百科</title>
        <link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
    <link href="http://www.wacxt.cn/missyou/static/app.1631891d7f92e6d1ae006cb7b0ba514b.css" rel="stylesheet"></head>
    <body>
        <app></app>
    <script type="text/javascript" src="http://www.wacxt.cn/missyou/static/app.8e2e890e2a54a53b54c4.js"></script></body>
</html>
