<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://192.168.2.20/ksb/xs/Exquery.asp');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'xh=2016010001&SubValue=%B2%E9++%D1%AF');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$res = curl_exec($ch);
curl_close($ch);

$res1 = iconv('gbk', 'UTF-8', $res);

header('Content-Type: text/html; charset: utf-8');

preg_match_all('/<td\s+>(.*)<\/td>/U', $res1, $r);

$r[1][4] = str_replace('<kcid=C509&sjid=">', '', $r[1][4]);
$r[1][4] = str_replace('</a>', '', $r[1][4]);

print_r($r[1]);

?>