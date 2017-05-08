<?php
require_once '../libs/pdo.class.php';
require_once '../libs/proxy.lib.php';
require_once '../config.php';
$db = new lpdo($_pdo);

$aid = $_GET['id'];

$source = httpGet('http://www.szu.edu.cn/board/view.asp?id=' . $aid);
$source = preg_replace('/\s{2,}|\r|\n/', '', iconv('GBK', 'UTF-8', $source));

preg_match('/(\d{4}-\d{1,2}-\d{1,2}\s+\d{1,2}:\d{1,2}:\d{1,2}).+/', $source, $lastEdit);

$isSaved = $db->get_one('sdbk_board_article', array('aid' => $aid));

if ($isSaved['lastedit'] == $lastEdit[1]) {
    echo json_encode($isSaved);
} else {
    $article = array();
    $article['aid'] = $aid;

    // 获取文章区域
    $artilcleAreaPattern = '/<table border="0" cellspacing="0" cellpadding=4 style="border-collapse: collapse" width="85%">(.+)<\/table>/';
    preg_match($artilcleAreaPattern, $source, $articleArea);
    $articleArea = $articleArea[1];

    // 获取标题
    preg_match('/<td class=fontcolor3 align=center height="60">(.*)<\/td>/U', $articleArea, $temp);
    $article['title'] = preg_replace('/^\s+|\s+$|　+/', '', strip_tags($temp[1]));
    // 获取部门和发布时间
    preg_match('/<td align=center height=30 style="font-size: 9pt">(.*)<\/td>/U', $articleArea, $temp);
    $temp = explode('　', strip_tags($temp[1]));
    $article['department'] = $temp[0];
    $article['releasetime'] = $temp[1];
    // 获取文章
    preg_match_all('/<tr>(.*)<\/tr>/U', $articleArea, $temp);
    $article['article'] = $temp[1][2];
    $article['article'] = preg_replace('/\s+style="[^"]+"/', '', $article['article']);
    $article['article'] = preg_replace('/\s+width="[^"]+|width=\d+/', '', $article['article']);
    $article['article'] = preg_replace('/\s+lang="[^"]+"/', '', $article['article']);
    $article['article'] = preg_replace('/\s+lang=[^>]+/', '', $article['article']);
    $article['article'] = preg_replace('/\s+href="mailto:[^"]+"/', '', $article['article']);
    $article['article'] = preg_replace('/<SPAN><\\SPAN>/', '', $article['article']);
    $article['article'] = preg_replace('/<SPAN>(.*)<\/SPAN>/U', '$1', $article['article']);
    $article['article'] = preg_replace('/\/board\/uploadfiles\//U', 'http://www.szu.edu.cn/board/uploadfiles/', $article['article']);
    $article['article'] = str_replace('<?xml:namespace prefix = o ns = "urn:schemas-microsoft-com:office:office" />', '', $article['article']);
    // 获取附件
    $attExisted = preg_match_all('/<a href=uploadfiles\/.* target=_blank>.*<\/a>/U', $articleArea, $temp);
    if ($attExisted) {
        $attrs = array();
        foreach ($temp[0] as $attr) {
            $a = array();

            preg_match('/<a href=uploadfiles\/(.*) target=_blank>(.*)<\/a>/U', $attr, $atemp);

            $a['url'] = 'http://www.szu.edu.cn/board/uploadfiles/' . $atemp[1];
            $a['name'] = str_replace('·', '', $atemp[2]);

            array_push($attrs, $a);
        }
        $article['attachment'] = base64_encode(json_encode($attrs));
    } else {
        $article['attachment'] = base64_encode(json_encode(array()));
    }

    $article['lastedit'] = $lastEdit[1];

    if ($isSaved) {
        $article['count'] = $isSaved['count'];
        $db->update('sdbk_board_article', $article, array('aid' => $aid));
    } else {
        $article['count'] = 0;
        $db->insert('sdbk_board_article', $article);
    }
    
    header('Content-Type: application/json');
    echo json_encode($article);

}

?>