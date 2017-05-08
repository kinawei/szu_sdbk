<?php
/**
  * 深大百科教师接访信息查询接口
  */

//define your token
define("TOKEN", "szuphone");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
//echo '';
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
                if ($keyword == 'openid') {
                    $contentStr = $fromUsername;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                $data = $this->fetchTeacher($keyword);
                $contentStr = $this->template($data);
                
                if($contentStr == '') {
                    $contentStr ="没有找到相关信息哦！";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                }
                //$contentStr = @iconv('UTF-8','gb2312', $data);
                $resultStr = sprintf($contentStr, $fromUsername, $toUsername, $time, 'news');
                //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, 'test');
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

    /**
     * [fetchTeacher]
     * @param  [string] $keyword [用户发送过来的关键词]
     * @return [array]          [老师信息数组]
     */
    function fetchTeacher ($keyword){
        $parsedKeyword = $keyword;

        //查询数据库
        include '../libs/mysql.class.php';
        $Mysql = new Mysql();

        //对数据库查询出来的数据进行处理
        $data = array();
        $i = 0;

        if (preg_match('/老师/', $parsedKeyword)) {
            //去除指定字符
            $parsedKeyword = str_replace('老师+', '', $parsedKeyword);
            $parsedKeyword = str_replace('老师 ', '', $parsedKeyword);
            $parsedKeyword = str_replace('老师-', '', $parsedKeyword);
            $parsedKeyword = str_replace('的电话', '', $parsedKeyword);
            $parsedKeyword = str_replace('老师', '', $parsedKeyword);

            //去除指定字符并进行安全处理
            $parsedKeyword = $this->parseKeywork($parsedKeyword);

            $resultData = $Mysql->Selects("*", "sdbk_teacherphone", "`teacher` like '%".$parsedKeyword."%' ");
            if ($resultData && $parsedKeyword != '') {
                while ($selectData = mysql_fetch_array($resultData)) {
                    $data['teacher'][$i]['college'] = $selectData['college'];
                    $data['teacher'][$i]['name'] = $selectData['teacher'];
                    $data['teacher'][$i]['time'] = $selectData['atime'];
                    $data['teacher'][$i]['place'] = $selectData['aplace'];
                    $data['teacher'][$i]['phone'] = $selectData['phone'];
                    $data['teacher'][$i]['remarks'] = $selectData['remarks'];
                    $i++;
                }
                $data['status'] = 'teacher';
            } else {
                $data['status'] = 'empty';
            }
        } elseif (preg_match('/学院/', $parsedKeyword)) {
            //去除指定字符
            $parsedKeyword = str_replace('学院+', '', $parsedKeyword);
            $parsedKeyword = str_replace('学院 ', '', $parsedKeyword);
            $parsedKeyword = str_replace('学院-', '', $parsedKeyword);
            $parsedKeyword = str_replace('学院', '', $parsedKeyword);

            //去除指定字符并进行安全处理
            $parsedKeyword = $this->parseKeywork($parsedKeyword);

            $resultData1 = $Mysql->Selects("*", "sdbk_cataphone", "`cata` like '%".$parsedKeyword."%' ");
            if ($resultData1 && $parsedKeyword != '') {
                $selectData1 = mysql_fetch_array($resultData1);
                $data['cata'] = $selectData1['cata'];
                $data['phone'] = $selectData1['phone'];
                $data['ybphone'] = $selectData1['ybphone'];
                $data['location'] = $selectData1['location'];
                $data['status'] = 'cata';
            } else {
                $data['status'] = 'empty';
            }
        } elseif (preg_match('/宿舍/', $parsedKeyword)) {
            //去除指定字符
            $parsedKeyword = str_replace('宿舍+', '', $parsedKeyword);
            $parsedKeyword = str_replace('宿舍 ', '', $parsedKeyword);
            $parsedKeyword = str_replace('宿舍-', '', $parsedKeyword);
            $parsedKeyword = str_replace('宿舍', '', $parsedKeyword);

            //去除指定字符并进行安全处理
            $parsedKeyword = $this->parseKeywork($parsedKeyword);

            $resultData = $Mysql->Selects("*", "sdbk_dormphone", "`dorm` like '%".$parsedKeyword."%' ");
            $teacherResultData = $Mysql->Selects("*", "sdbk_dormtphone", "`dorm` like '%".$parsedKeyword."%' ");
            if ($resultData && $teacherResultData && $parsedKeyword != '') {
                $selectData = mysql_fetch_array($resultData);
                $teacherSelectData = mysql_fetch_array($teacherResultData);
                $data['dorm'] = $selectData['dorm'];
                $data['phone'] = $selectData['phone'];
                $data['teacher'] = $teacherSelectData['teacher'];
                $data['location'] = $teacherSelectData['location'];
                $data['teacherPhone'] = $teacherSelectData['phone'];
                $assResultData = $Mysql->Selects("*", "sdbk_dormassphone", "`teacher` = '".$teacherSelectData['teacher']."' ");
                if ($assResultData) {
                    while ($assSelectData = mysql_fetch_array($assResultData)) {
                        $assSelectData['ass'] = explode('1', $assSelectData['ass']);
                        $assSelectData['ass'][1] = '1'.$assSelectData['ass'][1];
                        $data['ass'][$i]['assname'] = $assSelectData['ass'][0];
                        $data['ass'][$i]['assclass'] = $assSelectData['ass'][1];
                        $data['ass'][$i]['assdorm'] = $assSelectData['assdorm'];
                        $data['ass'][$i]['assphone'] = $assSelectData['assphone'];
                        $i++;
                    }
                }
                $data['status'] = 'dorm';
            } else {
                $data['status'] = 'empty';
            }
        } 

        //返回数组
        return $data;
        
    }

    function parseKeywork($keyword)
    {
        //安全处理
        $keyword = strip_tags($keyword);
        $keyword = addslashes($keyword);
        $keyword = str_replace('_', '\_', $keyword);
        $keyword = str_replace('%', '\%', $keyword);

        //返回处理完字符
        return $keyword;
    }

    /**
     * [template]
     * @param  [array] $data [老师信息数组]
     * @return [string]       [带格式的模板]
     */
    function template($data)
    {
        if (array_key_exists('status', $data) && $data['status'] == 'empty') {
            return '';
            exit;
        }

        $dataCount = count($data);

        $templateHead = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>'.$dataCount.'</ArticleCount>
<Articles>';
        $templateFoot = '</Articles>
</xml>';
        $templateItem = '<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>';
        
        $template = $templateHead;

        if ($data['status'] == 'dorm') {
            $template .= sprintf($templateItem, '深大百科宿舍相关事务联系方式查询', '', 'http://cdn.www.wacxt.cn/res/images/szudormphone.jpg', '');
            $writeData = "【宿舍名】".$data['dorm']."\n【联系电话】".$data['phone']."\n\n【社区辅导员】".$data['teacher']."\n【辅导员联系电话】".$data['teacherPhone']."\n【辅导员宿舍】".$data['location'];
            $template .= sprintf($templateItem, $writeData, '', '', '');
            $writeData = "【社区辅导员助理】";
            for ( $i = 0; $i < count($data['ass']); $i++) { 
                $writeData .= "\n\n【辅导员助理】".$data['ass'][$i]['assname']."\n【年级】".$data['ass'][$i]['assclass']."\n【助理宿舍】".$data['ass'][$i]['assdorm']."\n【助理联系电话】".$data['ass'][$i]['assphone'];
            }
            $template .= sprintf($templateItem, $writeData, '', '', '');
        } elseif ($data['status'] == 'cata') {
            $template .= sprintf($templateItem, '深大百科学院联系方式查询', '', 'http://cdn.www.wacxt.cn/res/images/szucataphone.jpg', '');
            $writeData = "【学院】".$data['cata']."\n【院办电话】".$data['ybphone']."\n【教学秘书电话】".$data['phone']."\n【教学秘书办公室地点】".$data['location'];
            $template .= sprintf($templateItem, $writeData, '', '', '');
        } elseif ($data['status'] == 'teacher') {
            $template .= sprintf($templateItem, '深大百科教师联系方式查询', '', 'http://cdn.www.wacxt.cn/res/images/szuteacherphone.jpg', '');
            for ($i = 0; $i < count($data['teacher']); $i++) {
                if (empty($data['teacher'][$i]['time']) || $data['teacher'][$i]['time'] == '') {
                    $data['teacher'][$i]['time'] = '暂无';
                } else if (empty($data['teacher'][$i]['place']) || $data['teacher'][$i]['place'] == '') {
                    $data['teacher'][$i]['place'] = '暂无';
                } else if (empty($data['teacher'][$i]['phone']) || $data['teacher'][$i]['phone'] == '') {
                    $data['teacher'][$i]['phone'] = '暂无';
                } else if (empty($data['teacher'][$i]['remarks']) || $data['teacher'][$i]['remarks'] == '') {
                    $data['teacher'][$i]['remarks'] = '无';
                } else {
                    $data['teacher'][$i]['remarks'] .= '。如果没有老师电话，建议直接去办公室找老师。';
                }
                $writeData = "【老师学院】".$data['teacher'][$i]['college']."\n【老师姓名】".$data['teacher'][$i]['name']."\n【接待时间】".$data['teacher'][$i]['time']."\n【接待地点】".$data['teacher'][$i]['place']."\n【办公电话】".$data['teacher'][$i]['phone']."\n【备注】".$data['teacher'][$i]['remarks'];
                $template .= sprintf($templateItem, $writeData, '', '', '');
            }
        }

        $template .= $templateFoot;

        return $template;
    }

}
?>