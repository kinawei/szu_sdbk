<?php
require_once '../config.php';
require_once '../libs/pdo.class.php';
$db = new lpdo($_pdo);
// 用户认证
if (isset($_COOKIE['openid'])) {
    $openid = $_COOKIE['openid'];
    $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/powerusage/"));
        exit();
    }
} else {
    header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/powerusage/"));
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>用电查询 - 深大百科</title>
        <link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
    <link href="http://www.wacxt.cn/powerusage/static/app.c7f531d6d7b50bd66de2e82db909eeaf.css" rel="stylesheet"></head>
    <body>
        <app></app>
    <script type="text/javascript" src="http://www.wacxt.cn/powerusage/static/app.797d7847c361847987dd.js"></script></body>
</html>
