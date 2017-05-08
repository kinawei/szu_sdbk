<?php
/**
  * 深大百科教师接访信息查询接口
  */
require_once '../config.php';
require_once './valid.class.php';
require_once './response.class.php';
require_once './rule.class.php';

$valid = new Valid(TOKEN);

if (!$valid->checkSignature()) {
    echo 'false';
    exit();
}

$res = new Response();

if (!$res) {
    echo 'false';
    exit();
} else {
	echo $_GET["echostr"];
}

$rule = new Rule($_pdo, $res);

$rule->dispatch();

?>