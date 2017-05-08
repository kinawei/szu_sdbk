<?php
require_once '../config.php';
require_once '../libs/pdo.class.php';
$_pdo['charset'] = 'utf8mb4';
$db = new lpdo($_pdo);

if (isset($_COOKIE['openid'])) {
    $openid = $_COOKIE['openid'];
    $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/missyou/"));
        exit();
    }
} else {
    header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/missyou/"));
    exit();
}

$channel = new SaeChannel();

$thisdorm = $db->get_one('sdbk_dorm_new', array('studentNo' => $userinfo['studentNo']));

if (!$thisdorm) {
    exit();
}

$allSameDorm = $db->query("SELECT * from `sdbk_dorm_new` LEFT JOIN `sdbk_user` ON `sdbk_dorm_new`.`studentNo` = `sdbk_user`.`studentNo` WHERE `sdbk_dorm_new`.`building` = '" . $thisdorm['building'] . "' and `sdbk_dorm_new`.`roomname` = '"  . $thisdorm['roomname'] . "'");

$data = json_decode(file_get_contents('php://input'), true);

foreach ($allSameDorm as $item) {
    if ($item['openid'] != $data['openid']) {
        $res = $channel->sendMessage($item['openid'], json_encode($data), true);
    }
}

$data['time'] = time();
$data['building'] = $thisdorm['building'];
$data['roomname'] = $thisdorm['roomname'];

$db->insert('sdbk_missyou_log', $data);

echo json_encode(array('status' => true));
?>