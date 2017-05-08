<?php
/**
 *	@copyright  Copyright (c) 2015 深大百科
 *	@author     Jason <jason@zingcss.com>
 */

class getfee
{
	const URL = 'http://szudk.szu.edu.cn:9090/cgcSims/selectList.do', //电费查询链接
		  CLIENT1 = '192.168.84.1', //北校区查询IP
		  CLIENT2 = '192.168.84.110'; //南校区查询IP
	private $client;

	/**
	 * 初始化时区
	 */
	function __construct() {
		date_default_timezone_set("ETC/GMT-8");
	}

	/**
	 * 查询当天电费
	 * @param int $roomId 房间ID
	 * @param int $roomName 房间号
	 * @param int $type 房间类型，北校区 or 南校区
	 */
	function fee ($roomId, $roomName, $roomType)
	{
		if ($roomType == 1) {
			$this->client = self::CLIENT1;
		} elseif ($roomType == 2) {
			$this->client = self::CLIENT2;
		} else {
			exit('参数 roomType 错误。');
		}

		//要POST的数据
		$post_data = array ();
		$post_data['hiddenType'] = "";
		$post_data['isHost'] = "0";
		$post_data['beginTime'] = date("Y-m-d", time());
		$post_data['endTime'] = date("Y-m-d", time());
		$post_data['type'] = "2";
		$post_data['client'] = $this->client;
		$post_data['roomId'] = $roomId;
		$post_data['roomName'] = $roomName;
		$post_data['building'] = "";

		$o = "";

		foreach ( $post_data as $k => $v ) 
		{ 
		     $o .= "$k=".urlencode($v)."&";
		} 

		$post_data = substr ($o, 0, -1);
		$ch = curl_initcas() ;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL, self::URL);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$regx = '/<td width="13%" align="center">\s*(.+)\s*<\/td>/u';
		$result = iconv('GBK', 'UTF-8', $result);
		preg_match_all($regx, $result, $matches);

		return $matches[0][2];
	}

	/**
	 * 查询多天电费
	 * @param int $roomId 房间ID
	 * @param int $roomName 房间号
	 * @param int $type 房间类型，北校区 or 南校区
	 * @param int $dateNum 要查询的天数
	 */
	function moreFee ($roomId, $roomName, $roomType, $dateNum)
	{
		if ($roomType == 1) {
			$this->client = self::CLIENT1;
		} elseif ($roomType == 2) {
			$this->client = self::CLIENT2;
		} else {
			exit('参数 roomType 错误。');
		}

		if ($dateNum > 15) {
			exit('查询天数不超过15天。');
		}

		//要POST的数据
		$post_data = array ();
		$post_data['hiddenType'] = "";
		$post_data['isHost'] = "0";
		$post_data['beginTime'] = date("Y-m-d", time()-($dateNum-1)*24*3600);
		$post_data['endTime'] = date("Y-m-d", time());
		$post_data['type'] = "2";
		$post_data['client'] = $this->client;
		$post_data['roomId'] = $roomId;
		$post_data['roomName'] = $roomName;
		$post_data['building'] = "";
		$o = "";
		foreach ( $post_data as $k => $v ) 
		{ 
		     $o .= "$k=".urlencode($v)."&";
		}
		$post_data = substr ($o, 0, -1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL, self::URL);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$regx = '/<td width="13%" align="center">\s*(.+)\s*<\/td>/u';
		$result = iconv('GBK', 'UTF-8', $result);
		preg_match_all($regx, $result, $matches);
		array_splice($matches, 0, 1);

		$printResult = array();
		for ($i = 0; $i < $dateNum; $i++) { 
			$printResult[$i]['date'] = date("Y-m-d", time()-$i*24*3600);
			$num = count($matches[0]) - 3 - $i*5;
			$printResult[$i]['fee'] = str_replace('\r', '', $matches[0][$num]);
		}

		return $printResult;
	}

}