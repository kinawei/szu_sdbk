<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_card';
$table_user = 'sdbk_user';

header('Content-Type:application/json');

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit('GG');
} else {
    exit(2);
}

    $action = $_GET['action'];

    if ($action == 'list') {

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if (!is_numeric($page)) {
            $page = 1;
        }

        $startRow = ($page - 1) * 20;

        $limit = 'order by id desc limit ' . $startRow . ',20';

        $column = array('id', 'studentNo', 'studentName', 'getName', 'isReturn');

        $list = $db->get_rows($table, array(), false, $column, $limit);

        echo json_encode($list);

    }

    else if ($action == 'add') {

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['studentNo'])) {
            echo json_encode("false1");
            exit();
        }

        $card = array(
            'studentNo' => $data['studentNo'],
            'studentName' => $data['studentName'],
            'getName' => $data['getName'],
            'remark' => $data['remark']
        );

        $insert = $db->insert($table, $card);

        if ($insert) {
            $log->save('添加校园卡丢失信息：'.$data['studentNo']);

            $cdt = array('studentNo' => $data['studentNo']);

            $user = $db->get_one($table_user, $cdt);

            include('../../../../libs/weixin.class.php');
            $obj = new weixin(APPID, APPSECRET);
            $template_id = 'bZkMNzBf8NrGO1ucZ4G-93TLMzJjr9qlqRHux7Tgvtw';
            $token = $obj->getToken();
            $token = json_decode($token, true);

            $textPic = array(
                'first' => array('value'=> $user['studentName'].'，你的校园卡被捡到啦！\n请到事务中心领取你的校园卡 <(￣▽￣)>', 'color'=> '#df4848'),
                'PickedTime' => array('value'=> date("Y-m-d", time()), 'color'=> '#408ec0'),
                'CardType' => array('value'=> '校园卡号'),
                'CardNum' => array('value'=> $user['icAccount'], 'color'=> '#333'),
                'PickerName' => array('value'=> $data['getName'], 'color'=> '#333'),
                'remark' => array('value'=> '\n如有问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb'),
            );

            $res = $obj->pushtemple($token['access_token'], $user['openid'], $template_id, $templeurl, $textPic);

            $res = json_decode($res, true);

            $result = array('status' => 'success', 'pushMsg' => 'success');

            if ($res['errmsg'] != 'ok') {
                $result['pushMsg'] = 'false';
            }

            echo json_encode($result);
            exit();
        } else {
            echo json_encode('false');
            exit();
        }

    }

    else if ($action == 'delete' && $userinfo['rank'] >= 5) {

        $id = isset($_GET['id']) ? (int)$_GET['id'] : exit();

        if (!is_numeric($id)) {
            exit('id');
        }

        $cdt = array('id' => $id);

        $card = $db->get_one($table, $cdt);

        $log->save('删除校园卡丢失信息：'.$card['studentNo']);

        $list = $db->delete($table, $cdt);

        if (is_numeric($list)) {

            echo json_encode('success');

        } else {

            echo json_encode('failed');

        }

    }

    else if ($action == 'getone') {

        $id = isset($_GET['id']) ? (int)$_GET['id'] : exit();

        if (!is_numeric($id)) {
            exit('id');
        }

        $cdt = array('id' => $id);

        $admin = $db->get_one($table, $cdt);

        echo json_encode($admin);

    }

    else if ($action == 'return') {

        $id = isset($_GET['id']) ? (int)$_GET['id'] : exit();

        if (!is_numeric($id)) {
            exit('id');
        }

        $card = array(
            'isreturn' => 1
        );

        $cdt = array('id' => $id);

        $update = $db->update($table, $card, $cdt);

        if ($update) {
            $cdt = array('id' => $id);

            $card = $db->get_one($table, $cdt);

            $cdt = array('studentNo' => $card['studentNo']);

            $user = $db->get_one($table_user, $cdt);

            include('../../../../libs/weixin.class.php');
            $obj = new weixin(APPID, APPSECRET);
            $template_id = 'bZkMNzBf8NrGO1ucZ4G-93TLMzJjr9qlqRHux7Tgvtw';
            $token = $obj->getToken();
            $token = json_decode($token, true);

            $textPic = array(
                'first' => array('value'=> $user['studentName'].'，你的校园卡已经归还给你啦！', 'color'=> '#df4848'),
                'PickedTime' => array('value'=> date("Y-m-d", time()), 'color'=> '#408ec0'),
                'CardType' => array('value'=> '校园卡号', 'color'=> '#333'),
                'CardNum' => array('value'=> $user['icAccount'], 'color'=> '#333'),
                'PickerName' => array('value'=> $card['getName'], 'color'=> '#333'),
                'remark' => array('value'=> '\n如果校园卡不是你本人拿走或有任何问题，请联系事务君（微信号：szushiwujun）', 'color'=> '#bbbbbb'),
            );

            $res = $obj->pushtemple($token['access_token'], $user['openid'], $template_id, $templeurl, $textPic);

            $res = json_decode($res, true);

            if ($res['errmsg'] != 'ok') {
                echo json_encode('false');
                exit();
            }

            $log->save('归还了校园卡：'.$user['studentNo']);

            echo json_encode('success');
            exit();
        } else {
            echo json_encode('false');
            exit();
        }

    }

    else if ($action == 'search') {

        $keyword = isset($_GET['keyword']) ? strip_tags($_GET['keyword']) : exit();

        $keyword = str_replace('\'', '', $keyword);

        $column = array('id', 'studentNo', 'studentName', 'getName', 'isReturn');

        $cdt = array('studentName' => $keyword, 'getName' => $keyword, 'remark' => $keyword);

        $list1 = $db->get_rows($table, $cdt, false, $column, '', 'like', 'OR');

        $cdt1 = array('id' => $keyword, 'studentNo' => $keyword);

        $list2 = $db->get_rows($table, $cdt1, false, $column, '', '=', 'OR');

        $list = array_merge($list1, $list2);

        echo json_encode($list);

    }

    else if ($action == 'getpage') {

        $list = $db->get_rows($table);

        $count = count($list);

        $output = intval($count / 20) + 1;

        echo json_encode($output);

    }

    else {

        exit(1);
        
    }


?>