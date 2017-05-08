<?php

/**
 * 定义回复接口
 */
interface Res {
    function getMsgType ();
    function getMsgContent ();
    function getMediaId ();
    function replyText ($text);
    function replyArticle ($arts);
}

/**
 * 实现回复接口类
 */
class Response implements Res
{
    private $req;
    
    function __construct ()
    {
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        if (empty($postStr)) {
            return false;
        }

        // 解析xml
        $this->req = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    public function getMsgType ()
    {
        return $this->req->MsgType;
    }

    public function getMsgContent ()
    {
        return $this->req->Content;
    }

    public function getMediaId ()
    {
        return $this->req->PicUrl;
    }

    public function replyText ($text)
    {
        echo '<xml><ToUserName><![CDATA['
            . $this->req->FromUserName
            . ']]></ToUserName><FromUserName><![CDATA['
            . $this->req->ToUserName
            . ']]></FromUserName><CreateTime>'
            . time()
            . '</CreateTime><MsgType><![CDATA['
            . 'text'
            . ']]></MsgType><Content><![CDATA['
            . $text
            . ']]></Content></xml>';
    }

    public function replyArticle ($arts)
    {
        $artCount = count($arts);

        $template = '<xml><ToUserName><![CDATA['
            . $this->req->FromUserName
            . ']]></ToUserName><FromUserName><![CDATA['
            . $this->req->ToUserName
            . ']]></FromUserName><CreateTime>'
            . time()
            . '</CreateTime><MsgType><![CDATA['
            . 'news'
            . ']]></MsgType><ArticleCount>'
            . $artCount
            . '</ArticleCount><Articles>';

        $templateFoot = '</Articles></xml>';

        $templateItem = '<item><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>';

        $i = 0;
        foreach ($arts as $art) {
            if ($i > 10) {
                break;
            }
            $template .= sprintf($templateItem, $art->title, $art->description, $art->picUrl, $art->url);
            $i++;
        }

        $template .= $templateFoot;

        echo $template;
    }

}

?>