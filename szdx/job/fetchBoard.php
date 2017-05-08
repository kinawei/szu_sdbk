<?php
require('../libs/phpQuery/phpQuery.php');
//header("Content-Type: application/json; charset=utf-8");

//fetchOrig
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://233.zingcss.applinzi.com/");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$orgi = curl_exec($curl);
curl_close($curl);

$orgi = str_replace("&nbsp;", " ", $orgi);
$orgi = str_replace("　", " ", $orgi);
$orgi = strtr($orgi, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));
$orgi = str_replace('<meta http-equiv="Content-Type" content="text/html; charset=gb2312">', '', $orgi);

$data = phpQuery::newDocument($orgi)['body > table > tbody > tr:nth-child(2) > td > table > tbody > tr:nth-child(3) > td > table > tbody > tr:nth-child(3) > td > table > tbody'];

print_r($data->find('tr')->elements[2]);
?>