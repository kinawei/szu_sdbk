<?php
include('../config.php');
include('../libs/weixin.class.php');
include '../libs/mysql.class.php';
$obj = new weixin(APPID, APPSECRET);
$template_id = 'qZLWFBXBFuj1z1aMliuKBY5XJHpWFHaOVChG2KjcrZA';
$templeurl='http://szdx.sinaapp.com/dianfei';
$token = $obj->getToken();
$token = json_decode($token, true);

$Mysql = new Mysql();
$resuleRows = $Mysql->Selects("*", "sdbk_room_warn", "");

while ($resule1 = mysql_fetch_array($resuleRows)) {

	$roomCode = $resule1['roomcode'];

	$result2 = $Mysql->Select("*", "sdbk_room", "`code` = ".$roomCode);

	$showRoom = $result2['building'].$result2['roomname'];

	if (   $result2['building'] == '春笛'
		|| $result2['building'] == '夏筝'
		|| $result2['building'] == '秋瑟'
		|| $result2['building'] == '冬筑' ) {
		$roomType = 2;
	} else {
		$roomType = 1;
	}

	$roomName = $result2['roomname'];
	$roomId = $result2['roomid'];

	$result = $Mysql->Select("*", "sdbk_room_fee", "`roomcode` = ".$roomCode);

	if (!$result) {
		$getfee = json_decode(file_get_contents("http://cie.szu.edu.cn/antennas/sdbk/df/api.php?roomname=".$roomName."&roomid=".$roomId."&roomtype=".$roomType), true);
		$fee = $getfee['fee'];
		$fee_15days = json_encode($getfee['fee_15days']);
		$updateTime = date("Y-m-d-H", time());
		$result = $Mysql->Insert("sdbk_room_fee", "roomcode,fee,fee_15days,updateTime", $roomCode.",".$fee.",'".$fee_15days."','".$updateTime."'");
		$data = $getfee;
	} else {
		$updateTime = explode('-', $result['updateTime']);
		if ($updateTime[0] == date("Y", time()) && $updateTime[1] == date("m", time())) {
			if ($updateTime[2] == date("d", time()) && $updateTime[3] >= 2) {
				$data = array();
				$data['fee'] = $result['fee'];
				$data['fee_15days'] = json_decode($result['fee_15days'], true);
            } else if ($updateTime[2] == (date("d", time()) - 1 ) && $updateTime[3] >= 2 && date("H", time()) <= 2){
            	$data = array();
				$data['fee'] = $result['fee'];
				$data['fee_15days'] = json_decode($result['fee_15days'], true);
        	}else {
				$getfee = json_decode(file_get_contents("http://cie.szu.edu.cn/antennas/sdbk/df/api.php?roomname=".$roomName."&roomid=".$roomId."&roomtype=".$roomType), true);
				$fee = $getfee['fee'];
				$fee_15days = json_encode($getfee['fee_15days']);
				$updateTime = date("Y-m-d-H", time());
                $result = $Mysql->Update("sdbk_room_fee", "fee = {$fee},fee_15days = '{$fee_15days}',updateTime = '{$updateTime}'", "`roomcode` = ".$roomCode);
				$data = $getfee;
			}
		} else {
			$getfee = json_decode(file_get_contents("http://cie.szu.edu.cn/antennas/sdbk/df/api.php?roomname=".$roomName."&roomid=".$roomId."&roomtype=".$roomType), true);
			$fee = $getfee['fee'];
			$fee_15days = json_encode($getfee['fee_15days']);
			$updateTime = date("Y-m-d-H", time());
			$result = $result = $Mysql->Update("sdbk_room_fee", "fee = {$fee},fee_15days = '{$fee_15days}',updateTime = '{$updateTime}'", "`roomcode` = ".$roomCode);
			$data = $getfee;
		}
	}

	if ( availableDays($data['fee_15days'], $data['fee']) <= 1){
		$textPic = array(
		    'first' => array('value'=> '根据深大百科数据中心预测，你的宿舍剩余电费只能使用不到1天啦！快去交电费吧！\n', 'color'=> '#df4848'),
		    'keynote1' => array('value'=> '未知', 'color'=> '#bbbbbb'),	
		    'keynote2' => array('value'=> $showRoom, 'color'=> '#316492'),
		    'keynote3' => array('value'=> $data['fee'].'度', 'color'=> '#df4848'),
		    'remark' => array('value'=> '\n如果不想接收提醒消息，可以点击本条消息进入宿舍电费查询关闭提醒哦^_^\n\n点击可以查询7日电费情况。', 'color'=> '#bbbbbb'),
		);
		$obj->pushtemple($token['access_token'], $resule1['openid'], $template_id, $templeurl, $textPic);
	}
    usleep(100000);
}

function availableDays ($data, $leftFee)
{
	$allFee = 0.00;
	$days = 0;
	for ($i=0; $i < count($data) - 1; $i++) { 
		if ( $data[$i]['fee'] >= 0 && $data[$i+1]['fee'] >=0 && ( $data[$i+1]['fee'] - $data[$i]['fee'] ) >= 0 ) {
			$allFee += (double)( $data[$i+1]['fee'] - $data[$i]['fee'] );
			$days++;
		}
	}
	$averageFee = $allFee / $days;
	return $availableDays = round(($leftFee / $averageFee), 0);
}
?>