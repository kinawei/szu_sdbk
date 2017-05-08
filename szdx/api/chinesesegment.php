<?php
header('Content-Type: application/json;charset:utf-8');
if (isset($_GET['string'])) {
    $seg = new SaeSegment();
    $ret = $seg->segment($_GET['string'], 1);
    print_r(json_encode($ret));
    if ($ret === false)
            var_dump(json_encode($seg->errmsg()));
} else {
    $output = array('err' => 'invaild string');
    echo json_encode($output);
}
?>