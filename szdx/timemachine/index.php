<?php
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();

if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
    if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/bxg"));
        exit();
    }
    $openid = $_COOKIE["openid"];
    $result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
    $userinfo = mysql_fetch_array($result);
    if ($userinfo['studentNo'] == 0) {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/bxg"));
        exit();
    }
} else {
    header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/bxg"));
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>时间胶囊 - 深大百科</title>
<link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
<link href="css/index.css" rel="stylesheet">
</head>
<body>
<div class="logo">
    <img src="./img/logo.png">
</div>
<div class="textfield">
    <textarea class="text" name='text'>写入你想存的话，期末打开~</textarea>
</div>
<div class="btn">
    <button onclick="save()">点击存入时间胶囊</button>
    <button onclick="myself()">查看我的时间胶囊</button>
</div>
<script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
<script>
function save () {
    var text = $('.text').val();
    if (text == '写入你想存的话，期末打开~' || text.replace(/\s/g, '') == '') {
        alert('嘿！你啥都没写呢！');
        return;
    }
    $.ajax({
        url: 'do.php',
        async: false,
        data: {
            text: text
        },
        dataType: 'json',
        success: function(msg) {
            if (msg.code == 0) {
                console.log("6666");
            } else {
                alert("额~~(╯﹏╰)b...好像发生了什么问题");
            }
        }
    });
}
function myself () {
    window.location.href = 'myself.php';
}
</script>
</body>
</html>