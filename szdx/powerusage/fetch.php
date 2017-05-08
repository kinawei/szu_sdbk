<?php
require_once '../config.php';
require_once '../libs/proxy.lib.php';
require_once '../libs/pdo.class.php';
date_default_timezone_set('Asia/Shanghai');
$db = new lpdo($_pdo);

header('Content-Type: application/json');

// 用户认证
if (!isset($_GET['roomcode'])) {
    if (isset($_COOKIE['openid'])) {
        $openid = $_COOKIE['openid'];
        $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
        if (!$userinfo) {
            echo json_encode(array('status' => false));
            exit();
        }
    } else {
        echo json_encode(array('status' => false));
        exit();
    }
    $roomInfo = $db->query("SELECT * FROM `sdbk_room_bind` left join `sdbk_room` on `sdbk_room_bind`.`code` = `sdbk_room`.`code` where `sdbk_room_bind`.`openid` = '". $openid ."'");
    if (!$roomInfo) {
        echo json_encode(array('status' => false));
        exit();
    }
    $roomInfo = $roomInfo[0];
} else {
    $roomcode = $_GET['roomcode'];
    if (!is_numeric($roomcode)) {
        echo json_encode(array('status' => false));
        exit();
    }
    $roomInfo = $db->query("SELECT * FROM `sdbk_room_bind` left join `sdbk_room` on `sdbk_room_bind`.`code` = `sdbk_room`.`code` where `sdbk_room_bind`.`code` = '". $roomcode ."'");
    if (!$roomInfo) {
        echo json_encode(array('status' => false));
        exit();
    }
    $roomInfo = $roomInfo[0];
}

$usageInfo = $db->get_one('sdbk_room_usage', array('code' => $roomInfo['code']));

// 获取宿舍区
$zhaiqu = array('风槐斋', '红榴斋', '海桐斋', '聚翰斋', '凌霄斋', '米兰斋', '木棉斋', '蓬莱公寓', '山茶斋', '桃李斋', '银桦斋', '雨鹃斋');
$qiaoge = array('乔木阁', '乔林阁', '乔森阁', '乔相阁', '乔梧阁');
$xinan = array('丹枫轩', '丁香阁', '杜衡阁', '海棠阁', '木犀轩', '石楠轩', '疏影阁', '苏铁轩', '文杏阁', '辛夷阁', '云杉轩', '芸香阁', '韵竹阁', '紫檀轩', '紫藤轩');
$nanqu = array('春笛', '夏筝', '秋瑟', '冬筑');

$roomBind = array();
if (in_array($roomInfo['building'], $nanqu)) {
    $roomBind['area'] = 'ny';
} else if (in_array($roomInfo['building'], $zhaiqu)) {
    $roomBind['area'] = 'ly';
} else if (in_array($roomInfo['building'], $qiaoge)) {
    $roomBind['area'] = 'qy';
} else if (in_array($roomInfo['building'], $xinan)) {
    $roomBind['area'] = 'xy';
}
$roomBind['building'] = $roomInfo['building'];
$roomBind['roomname'] = $roomInfo['roomname'];
$roomBind['warnpush'] = ($roomInfo['warnpush'] == 1) ? true : false;

if ($usageInfo) {
    $ts = (int)$usageInfo['lastFetch'];
    $usageInfo['roomBind'] = $roomBind;
    if (date('Y') == date('Y', $ts)
        && date('m') == date('m', $ts)
        && date('d') == date('d', $ts)
        && date('H', $ts) > 4) {
        echo json_encode($usageInfo);
        exit();
    } else if (date('Y') == date('Y', $ts)
        && date('m') == date('m', $ts)
        && date('d') == date('d', $ts) + 1
        && date('H') < 4) {
        echo json_encode($usageInfo);
        exit();
    } else if ($_GET['roomcode']
        && $usageInfo['enoughFor'] > 20
        && (time() - $ts) <= 60 * 60 * 24 * 2 ) {
        echo json_encode($usageInfo);
        exit();
    }
}

// 配置
$clients = array('192.168.84.1', '192.168.84.110');
$todayDate = implode('-', array(date('Y'), date('m'), date('d')));
$sevenAgoDate = implode('-', array(date('Y', time() - 60 * 60 * 24 * 7), date('m', time() - 60 * 60 * 24 * 7), date('d', time() - 60 * 60 * 24 * 7)));

// 获取数据
$building = $roomInfo['building'];
$roomName = $roomInfo['roomname'];
$roomId = $roomInfo['roomid'];
if (in_array($building, $nanqu)) {
    $type = 2;
} else {
    $type = 1;
}
$client = $clients[$type - 1];

// 构造请求
$data = array(
    'hiddenType' => '',
    'isHost' => '0',
    'beginTime' => $sevenAgoDate,
    'endTime' => $todayDate,
    'type' => 2,
    'client' => $client,
    'roomId' => $roomId,
    'roomName' => $roomName,                
    'building' => ''
);
$source = file_get_contents('http://cie.szu.edu.cn/antennas/sdbk/proxypost.php?url='.urlencode('http://192.168.84.3:9090/cgcSims/selectList.do').'&data='.base64_encode(json_encode($data)));

if (!$source) {
    $usageInfo['failed'] = false;
    echo json_encode($usageInfo);
    exit();
}

$source = preg_replace('/\s{2,}|\r|\n/', '', iconv('GBK', 'UTF-8', $source));

// 获取每日信息
$isFetched = preg_match_all('/<tr><td width="13%" align="center">.*<\/td><td width="13%" align="center">.*<\/td><td width="13%" align="center">(.*)<\/td><td width="13%" align="center">(.*)<\/td><td width="13%" align="center">.*<\/td><td width="22%" align="center">(\d{4}-\d{2}-\d{2}).*<\/td><\/tr>/U', $source, $items);

if (!$isFetched) {
    $usageInfo['failed'] = false;
    echo json_encode($usageInfo);
    exit();
}

$lists = array();
$sum = 0;
$sumUsage = 0;
for ($i = 0; $i < count($items[0]); $i++) {
    $lists[$i]['date'] = $items[3][$i];
    $lists[$i]['last'] = $items[1][$i];
    $sum += $items[1][$i];
    if ($i != count($items[0]) - 1 && $items[1][$i+1] > $items[1][$i]) {   
        $sumUsage += abs($items[1][$i+1] - $items[1][$i]);
    } else if ($i != count($items[0]) - 1 && $items[1][$i+1] < $items[1][$i]) {
        $sumUsage += abs($items[2][$i+1] - $items[2][$i]);
    }
}
$lists = array_reverse($lists);
if ($sumUsage == 0) {
    $averageUsage = 0;
    $enoughFor = 100;
} else {
    $averageUsage = number_format($sumUsage / 8, 3);
    if ($lists[0]['last'] < 0) {
        $enoughFor = 0;
    } else {
        $enoughFor = floor($lists[0]['last'] / $averageUsage);
    }
}
$yesterdayUsage = number_format($items[2][count($items[2]) - 1] - $items[2][count($items[2]) - 2], 2);

$roomUsage = array(
    'code' => $roomInfo['code'],
    'yesterdayUsage' => abs($yesterdayUsage),
    'lastUsage' => $lists[0]['last'],
    'lastUpdate' => $lists[0]['date'],
    'averageUsage' => $averageUsage,
    'enoughFor' => abs($enoughFor),
    'sevenDayData' => json_encode($lists),
    'lastFetch' => (string)time()
);

if ($usageInfo) {
    $db->update('sdbk_room_usage', $roomUsage, array('code' => $roomUsage['code']));
} else {
    $db->insert('sdbk_room_usage', $roomUsage);
}

$roomUsage['roomBind'] = $roomBind;

echo json_encode($roomUsage);
?>