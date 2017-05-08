<?php
/**
  * 深大百科教师接访信息查询接口
  */

//define your token
define("TOKEN", "xuefei");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

header("Content-Type: text/xml");

class wechatCallbackapiTest
{
    public function valid()
    {
        if( $this->checkSignature() ) {
            $this->responseMsg();
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //extract post data
        if ( !empty($postStr) ) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = time();
            $msgType = "text";
            $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
            $contentStr = $this->fetchCet($fromUsername);
            if($contentStr == 'unbind student card') {
                $contentStr ="要先绑定校园卡哦！";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $contentStr);
                echo $resultStr;
                exit;
            } else if ($contentStr == 'empty cet card') {
                $contentStr ="没有你的学费信息|･ω･｀)";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $contentStr);
                echo $resultStr;
                exit;
            }
            $studentNo = $contentStr['studentNo'];
            $name = $contentStr['studentName'];
            $xuefei = $contentStr['xuefei'];
            $zhusu = $contentStr['zhusu'];
            $sum = $contentStr['sum'];
            //$contentStr = @iconv('UTF-8','gb2312', $data);
            $text = "姓名：".$name."\n学号：".$studentNo."\n学费：".$xuefei."\n住宿费：".$zhusu."\n总费用：".$sum;
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $text);
            echo $resultStr;
            exit;
        } else {
            echo "1";
            exit;
        }
    }
  
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"]; 
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ) {
            return true;
        }else{
            return false;
        }
    }

    function fetchCet ($fromUsername){
        $openid = $fromUsername;

        //查询数据库
        include '../config.php';
        include '../libs/mysql.class.php';
        $Mysql = new Mysql();

        //对数据库查询出来的数据进行处理
        $user = $Mysql->Select('*', 'sdbk_user', " `openid` = '".$openid."'");

        if ($user['studentNo'] == 0) {
            return 'unbind student card';
        } else {
            $studentNo = $user['studentNo'];
        }

        $cetzkz = $Mysql->Selects('*', 'sdbk_xuefei', " `studentNo` = ".$studentNo);

        if (mysql_num_rows($cetzkz) != 0) {
            return mysql_fetch_assoc($cetzkz);
        } else {
            return 'empty cet card';
        }
    }
}
?>