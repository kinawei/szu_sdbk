<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_user';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit();
}

$issue = array(
    'replied' => 1,
    'asso' => $data['asso'],
    'reply' => $data['reply'],
    'responder' => $userinfo['username'],
    'replyTime' => time()
);

$log->save('回复了事务：'.json_encode($issue));

$cdt = array('id' => $data['id']);

$update = $db->update('sdbk_issue', $issue, $cdt);

$issue = $db->get_one('sdbk_issue', $cdt);

$cdt = array('userid' => $issue['userid']);

$user = $db->get_one('sdbk_user', $cdt);

if ($update) {
    include('../../../../libs/weixin.class.php');
    $obj = new weixin(APPID, APPSECRET);
    $template_id = 'XjbVBFEvMhZ2_UaTMqzntH3bMVbcr8hS0u9xRlQ1WuM';
    $templeurl = 'http://szdx.sinaapp.com/issue/#!/issue/'.$data['id'];
    $token = $obj->getToken();
    $token = json_decode($token, true);
    $textPic = array(
        'first' => array('value'=> '您咨询的事务有回复啦！\n', 'color'=> '#df4848'),
        'keyword1' => array('value'=> $issue['title'], 'color'=> '#408ec0'),
        'keyword2' => array('value'=> date("Y-m-d h:i:s", time()).'\n回复概况：'.mb_substr(strip_tags($data['reply']), 0, 32, 'utf-8'), 'color'=> '#333'),
        'remark' => array('value'=> '\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb'),
    );
    $obj->pushtemple($token['access_token'], $user['openid'], $template_id, $templeurl, $textPic);
    echo json_encode('success');
    exit();
} else {
    echo json_encode('false');
    exit();
}

?>