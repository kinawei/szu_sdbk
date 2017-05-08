<?php
if (isset($_GET["ticket"])){
	$url = "http://szdx.sinaapp.com/passport/cas.php?ticket=".$_GET["ticket"];
	header("Location: ".$url);
} else {
	$CASserver = "https://auth.szu.edu.cn/cas.aspx/";//深圳大学统一身份认证URL**不能修改**
	$ReturnURL = "http://210.39.2.134/test/cas.php";//用户认证后跳回到您的网站，根据实际情况修改
	header("Location: ". $CASserver ."login?service=". $ReturnURL);
}
?>