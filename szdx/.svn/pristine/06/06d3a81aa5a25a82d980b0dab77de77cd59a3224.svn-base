<?php
header("content-type:text/html;charset=utf-8");
setcookie('openid', $openid, time() - 3600, '/', 'www.wacxt.cn');
setcookie('secret', md5($openid), time() - 3600, '/', 'www.wacxt.cn');
setcookie('redirect_uri', $_GET['redirect_uri'], time()-3600, '/', 'www.wacxt.cn');
echo "<br>清除cookie成功";
/*
if (!isset($_GET['code'])) {
	header("Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx36a4c7de498c0009&redirect_uri=".urlencode('http://szdx.sinaapp.com/passport/c.php')."&response_type=code&scope=snsapi_base&state=checkuser#wechat_redirect");
	exit();
}
$code = $_GET['code'];
$json = json_decode(file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx36a4c7de498c0009&secret=f3f0ce18a090568f7b20f4c66fd87b13&code='.$code.'&grant_type=authorization_code'), true);
$openid = $json['openid'];
echo $openid;
*/
?>