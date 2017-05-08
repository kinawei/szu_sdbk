<?php
include '../../../../libs/pdo.class.php';
include '../../../../config.php';
include '../log.class.php';
$log = new Log($_pdo);
$db = new lpdo($_pdo);
$table = 'sdbk_user';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_COOKIE['uuid'])) {
    $uuid = $_COOKIE['uuid'];
    $userinfo = $db->get_one('sdbk_admin', array('uuid' => $uuid));
    if (!$userinfo) exit();
} else {
    exit();
}

$uuid = getuuid();

$student = array(
    'uuid' => $uuid,
    'username' => $data['username'],
    'password' => sha1($data['password'].$uuid),
    'rank' => $data['rank']
);

$done = $db->insert('sdbk_admin', $student);

if (is_numeric($done)) {
    $log->save('添加学生：'.$student['username']);
    echo json_encode('success');
} else {
    echo json_encode('false');
}

function getuuid ()
{
    if( function_exists('com_create_guid') ){
        return com_create_guid();
    }
    else {
        mt_srand( (double)microtime() * 10000 );    // optional for php 4.2.0 and up.
        $charid = strtoupper( md5(uniqid(rand(), true)) );
        $hyphen = chr( 45 );
        $uuid = substr( $charid, 0, 8 ) . $hyphen
            . substr( $charid, 8, 4 ) . $hyphen
            . substr( $charid, 12, 4 ) . $hyphen
            . substr( $charid, 16, 4 ) . $hyphen
            . substr( $charid, 20, 12 );
        return $uuid;
    }
}

?>