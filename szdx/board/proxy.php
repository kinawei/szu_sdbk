<?php

echo httpGet('http://www.szu.edu.cn/board/');



function httpGet ($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_PROXY, 'proxy.szu.edu.cn:8080');
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, '135756:113015');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$curl_scraped_page = curl_exec($ch);
	curl_close($ch);
	return $curl_scraped_page;
}
?>