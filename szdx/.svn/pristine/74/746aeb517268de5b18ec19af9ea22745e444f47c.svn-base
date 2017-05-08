<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
include('../../../../libs/weixin.class.php');
$obj = new weixin(APPID, APPSECRET);
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$template_id = 'oBulYCzxFhDhGyOJbQU_ZLOEcrdDDPS3QEAg6U09tw0';
$token = $obj->getToken();
$token = json_decode($token, true);

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit();
}

if ($userinfo['rank'] >= 5) {

    $action = $_GET['action'];

    if ($action == 'list') {
        $limit = 'order by id desc';
        $list = $db->get_rows('sdbk_activity', array(), false, array(), $limit);
        echo json_encode($list);
    } else if ($action == 'delete') {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : exit();
        if (!is_numeric($id)) {
            exit('id');
        }
        $cdt = array('id' => $id);
        $list = $db->delete('sdbk_activity', $cdt);
        $cdt = array('aid' => $id);
        $list = $db->delete('sdbk_activity_record', $cdt);
        if (is_numeric($list)) {
            $log->save('删除了活动：'.$id);
            echo json_encode('success');
        } else {
            echo json_encode('failed');
        }
    } else if ($action == 'push') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = isset($data['id']) ? (int)$data['id'] : exit();
        $textPic = array(
            'first' => array('value'=> '恭喜你报名成功！\n', 'color'=> '#F45757'),
            'keyword1' => array('value'=> $data['keyword1'], 'color'=> '#2b2b2b'),
            'keyword2' => array('value'=> $data['keyword2'], 'color'=> '#2b2b2b'),
            'keyword3' => array('value'=> $data['keyword3'], 'color'=> '#2b2b2b'),
            'remark' => array('value'=> $data['remark'].'\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb')
        );
        $templeurl = 'http://szdx.sinaapp.com/act/#!/act/'.$id;
        $openids = array();
        if ($data['markstu'] == 'all') {
            $cdt = array('aid' => $id);
            $list = $db->get_rows('sdbk_activity_record', $cdt, false, array('uid'));
            for ($i = 0; $i < count($list); $i++) {
                $cdt = array('userid' => $list[$i]['uid']);
                $lists = $db->get_one('sdbk_user', $cdt);
                $openids[$i] = $lists['openid'];
            }
        } else {
            $spliceOpenid = str_replace( '，', ',', $data['markstu']);
            $spliceOpenid = explode(',', $spliceOpenid);
            for ($i = 0; $i < count($spliceOpenid); $i++) {
                $cdt = array('studentNo' => $spliceOpenid[$i]);
                $list = $db->get_one('sdbk_user', $cdt, array('openid'));
                $openids[$i] = $list['openid'];
            }
        }
        for ($i = 0; $i < count($openids); $i++) {
            $act = array('mark' => '1');
            $cdt = array('openid' => $openids[$i]);
            $uid = $db->get_one('sdbk_user', $cdt, array('uid'));
            $cdt = array('uid' => $uid['uid']);
            $update = $db->update('sdbk_activity_record', $act, $cdt);
            $obj->pushtemple($token['access_token'], $openids[$i], $template_id, $templeurl, $textPic);
        }
        $log->save('设置了活动参与者，活动名称：'.$data['keyword1']);
        echo json_encode('success');
    }
}



?>