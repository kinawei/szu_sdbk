<?php
include '../config.php';
$zhaiqu = array('风槐斋', '红榴斋', '海桐斋', '聚翰斋', '凌霄斋', '米兰斋', '木棉斋', '蓬莱公寓', '山茶斋', '桃李斋', '银桦斋', '雨鹃斋');
$qiaoge = array('乔木阁', '乔林阁', '乔森阁', '乔相阁', '乔梧阁');
$xinan = array('丹枫轩', '丁香阁', '杜衡阁', '海棠阁', '木犀轩', '石楠轩', '疏影阁', '苏铁轩', '文杏阁', '辛夷阁', '云杉轩', '芸香阁', '韵竹阁', '紫檀轩', '紫藤轩');
$nanqu = array('春笛', '夏筝', '秋瑟', '冬筑');
$dormArea = array('zhaiqu' => $zhaiqu, 'qiaoge' => $qiaoge, 'xinan' => $xinan, 'nanqu' => $nanqu);
//定义回调地址
if (!isset($_GET['state'])) {
    header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".urlencode("http://www.wacxt.cn/dianfei/dorm.php")."&response_type=code&scope=snsapi_base&state=".$_GET['dorm']."#wechat_redirect");
} else if (!isset($_GET['code'])) {
    die("授权错误。");
}
$jsondata = json_decode(file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$_GET['code']."&grant_type=authorization_code"), true);
$openid = $jsondata['openid'];
//$openid = 'ADsdaj2ewdq9asch32sdsa3ef';
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>用电查询-深大百科</title>
<link href="css/common.min.css" rel="stylesheet">
<link href="css/dorm.css?v=1" rel="stylesheet">
</head>
<body ontouchstart="" class="body-fight">
<div class="header">
	<h1>请选择宿舍</h1>
</div>
<div class="dorm">
    <form action="detail.php?openid=<?php echo $openid; 
    if ($_GET['state'] == 'nanqu') {
        echo "&type=2";
    }?>" method="post">
        <div class="dormArea">
            <div class="dormArea-label">
                选择宿舍楼
            </div>
            <div class="dormArea-select">
                <select name="dormArea">
                <?php
                    $getDorm = $_GET['state'];
                    for ($i=0; $i < count($dormArea[$getDorm]); $i++) { 
                        echo "<option value=\"".$dormArea[$getDorm][$i]."\">".$dormArea[$getDorm][$i]."</option>";
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="dormId">
            <div class="dormId-label">
                填写宿舍号
            </div>
            <div class="dormId-input">
                <input type="number" name="dormId" maxlength="4" required/>
            </div>
        </div>
        <div class="code">
            <div class="code-label">
                验证码
            </div>
            <div class="code-input">
                <input type="text" name="code" maxlength="4" required/>
            </div>
            <div class="code-img">
                <img src="getcode.php" id="checkpic" onclick="changing();"/>
            </div>
        </div>
        <div class="confirm">
            <input type="submit" value="确  定"/>
        </div>
    </form>
</div>
<script type="text/javascript">
    function changing(){
        document.getElementById('checkpic').src="getcode.php?"+Math.random();
    }
</script>
</body>
</html>