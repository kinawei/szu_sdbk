<?php
$content = file_get_contents('http://cdn.iszu.cn/auththeme/2/Niagara%20Falls.jpg');
header("Cache-Control: max-age=86400");
header("Expires: " . date(DATE_RFC822,strtotime(" 1 day")));
header('Content-type: image/jpg');
echo $content;
?>