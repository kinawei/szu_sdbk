<?php
include '../../libs/pdo.class.php';
include '../../config.php';
$db = new lpdo($_pdo);
$table = 'sdbk_user';

// header('Access-Control-Allow-Origin:*');
// header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
// header('Access-Control-Allow-Headers:x-requested-with,content-type');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_COOKIE["openid"])) {
    $openid = $_COOKIE["openid"];
    $userinfo = $db->get_one($table, array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        echo json_encode('unlogin student card');
        exit();
    }
} else {
    echo json_encode('false login');
    exit();
}

if ($userinfo['userid'] != $data['userid']) {
    echo json_encode('false req');
    exit();
}

$issue = array(
    'title' => strip_tags($data['title']),
    'content' => strip_tags($data['content'], '<br><font><b><strong>'),
    'userid' => $data['userid'],
    'hidden' => $data['hidden'] ? 1 : 0,
    'submitTime' => time()
);

if (!isset($data['title'])) {
    exit('123');
}

if ($userinfo['phone'] == '0') {
    // var_dump($issue);
    $phone = array('phone' => $data['phone']);
    $userid = array('userid' => $data['userid']);

    $updatePhone = $db->update($table, $phone, $userid);

    if (!$updatePhone) {
        echo json_encode('update phone false');
        exit();
    }
}

$insert = $db->insert('sdbk_issue', $issue);

if ($insert) {
    echo json_encode('issue push success');
    exit();
} else {
    echo json_encode('issue push false');
    exit();
}

?>