<?php
header("Content-Type: application/json");
$ch = curl_init();
$url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$_SERVER["REMOTE_ADDR"];
$header = array(
    'apikey: e7d0a7eb9962e16b64d5aa19f68fa270',
);
// 添加apikey到header
curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
curl_setopt($ch , CURLOPT_URL , $url);
$city = json_decode(curl_exec($ch), true);
$cityname = ($city['retData']['city'] == 'None') ? '深圳' : $city['retData']['city'];

$ch = curl_init();
$url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.$cityname;
// 添加apikey到header
curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
curl_setopt($ch , CURLOPT_URL , $url);
$weather = json_decode(curl_exec($ch), true);
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE');  
header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
echo json_encode($weather['retData']);
?>