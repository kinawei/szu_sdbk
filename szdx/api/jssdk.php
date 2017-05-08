<?php
require_once "../libs/jssdk.php";
require_once "../config.php";
$jssdk = new JSSDK(APPID, APPSECRET, $_GET['type']);
$signPackage = $jssdk->GetSignPackage();
header("Content-Type: application/json");
echo json_encode($signPackage);
?>