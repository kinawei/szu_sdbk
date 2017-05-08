<?php
/*
function httpGet ($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_PROXY, 'proxy.szu.edu.cn:8080');
    curl_setopt($curl, CURLOPT_PROXYUSERPWD, '135756:113015'); 
    $request = curl_exec($curl);
    curl_close($curl);
    return $request;
}
*/

function httpGet ($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://cie.szu.edu.cn/antennas/sdbk/proxy1.php?url='.urlencode($url));
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $request = curl_exec($curl);
    curl_close($curl);
    return $request;
}
?>