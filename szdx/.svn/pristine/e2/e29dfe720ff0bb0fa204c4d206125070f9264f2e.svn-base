<?php
/**
* 回复规则
*/
require_once '../libs/pdo.class.php';

class Rule extends lpdo
{
    private $res;
    
    function __construct ($options, Res $res)
    {
        try
        {
            parent::__construct($options);
        }
        catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }

        // 引入回复接口
        $this->res = $res;
    }

    public function dispatch ()
    {
        $msgType = $this->res->getMsgType();

        // 获取路由
        $cdt = array('type' => (string)$msgType);
        $keywords = parent::get_rows('wechat_keywords', $cdt, false, array(), 'order by `weight` desc');

        if ($msgType == 'text') {
            if (preg_match('/^宿舍|宿舍$|^老师|老师$|学院$/i', $this->res->getMsgContent())) {
                include_once '../phone/api.php';
            } else if (preg_match('/^ks/i', $this->res->getMsgContent())) {
                $this->replyClass($this->res->getMsgContent());
            } else {
                $this->replyText($keywords);
            }
        } else if ($msgType == 'image') {
            $this->res->replyText($this->res->getMediaId());
        }
    }

    private function replyClass ($xh)
    {
        $xhStatus = preg_match('/^ks(\d{10})/i', $this->res->getMsgContent(), $xh);

        if (!$xhStatus) {
            $this->res->replyText('学号格式错误！格式为：ks2014130355');
            return false;
        }

        if (preg_match('/^2016/', $xh[1]) == 0) {
            $this->res->replyText('哼哼~你伪装小鲜肉！');
            return false;
        }

        // $cdt = array('studentNo' => $xh[1]);
        // $info = parent::get_one('sdbk_class', $cdt);

        $res = json_decode(file_get_contents('http://cie.szu.edu.cn/antennas/sdbk/getks.php?xh='.$xh[1]), true);

        if ($res['xh'] == null) {
            $this->res->replyText('没有找到你的考试信息哦！');
            return false;
        }

        $this->res->replyText('新生英语入学考试考场查询结果
学号：' . $xh[1] . '
考试时间：' . $res['sj'] . '
考试地点：' . $res['dd'] . '
考场：' . $res['kc']);
    }

    private function replyText ($keywords)
    {
        for ($i = 0; $i < count($keywords); $i++) {
            if (preg_match('/' . $keywords[$i]['keyword'] . '/i', $this->res->getMsgContent())) {
                $this->response($keywords[$i]['replyType'], $keywords[$i]['reply']);
                return true;
            }
        }

        $defaultKeyword = parent::get_one('wechat_keywords', array('type' => 'all'));
        $this->res->replyText($defaultKeyword['reply']);
    }

    private function response ($type, $reply)
    {
        if ($type == 'text') {
            $this->res->replyText($reply);
        } else if ($type == 'article') {
            $reply = json_decode($reply);
            $this->res->replyArticle($reply);
        }
    }



}

?>