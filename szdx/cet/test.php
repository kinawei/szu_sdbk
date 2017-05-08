<?php
/**
  * 深大百科教师接访信息查询接口
  */

//define your token
define("TOKEN", "test");
 $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
var_dump($postObj);
    $fromUsername = $postObj->FromUserName;
	echo $fromUsername;
    $toUsername = $postObj->ToUserName;
	echo $toUsername;
    $time = time();
    $msgType = "text";
    $textTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[%s]]></MsgType>
    <Content><![CDATA[%s]]></Content>
    </xml>";
$contentStr="你好";
$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $contentStr);
echo $resultStr;
?>