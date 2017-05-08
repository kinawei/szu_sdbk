<?php
/**
  * 深大百科签到接口
  */

//define your token
define("TOKEN", "sign_in");

//查询数据库
include '../config.php';
include '../libs/mysql.class.php';
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
	        $keyword = trim( $postObj->Content );
	        $time = time();
	    	$msgType = "text";
	        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
            if(!empty($keyword)) {
                $is_bind = $this->isBind($fromUsername);
                if(!$is_bind){
                    $contentStr = "不好意思，您还没绑定校园卡，请点击<a href='http://szdx.sinaapp.com/passport/'>绑定</a>";
                }else{
                    $now = date("Y-m-d");
                    
                    $contentStr = "恭喜签到成功，这是你第X次签到，再接再厉哦！";
                }
                //$contentStr = "开发中。。。";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
		       	exit;
		    } else {
		        $contentStr = "输入非法！";//$this->template($data);
		        //$contentStr = @iconv('UTF-8','gb2312', $data);
		    	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		        echo $resultStr;
		        exit;
		    }
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

	function isBind($openid){
		$Mysql = new Mysql();
        
		$result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
		$userinfo = mysql_fetch_array($result);
		if ($userinfo['studentNo'] == 0) {
			return false;
		}else{
            return true;
		}
	}

}
?>