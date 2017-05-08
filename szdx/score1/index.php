<?php
require_once '../config.php';
require_once '../libs/pdo.class.php';
$db = new lpdo($_pdo);

// 用户认证
if (isset($_COOKIE['openid'])) {
    $openid = $_COOKIE['openid'];
    $userinfo = $db->get_one('sdbk_user', array('openid' => $openid));
    if ($userinfo['studentNo'] == 0) {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/score/"));
        exit();
    }
} else {
    header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/score/"));
    exit();
}

// header("Content-Type:text/html; charset:utf-8");
// 
/*
if ($userinfo['openid'] != 'ohHvIjoJeahJQ_e1svpDIv2YAlS4'
    && $userinfo['openid'] != 'ohHvIjmSs7vc2jx6xzxwozfl_bdk'
    && $userinfo['openid'] != 'ohHvIjlrLSiV4jyA9NhDOTHOMnxU'
    && $userinfo['openid'] != 'ohHvIjsu8TSHitvhM7W6tmpofDTc'
    && $userinfo['openid'] != 'ohHvIjkK34kVxhV5gapxPDvHKm-Y'){
    echo "系统暂未开放！";
    exit();
}

    && $userinfo['openid'] != 'ohHvIjsTpsi4PmzqTcgcM-2BSkQY'
    && $userinfo['openid'] != 'ohHvIjhmt2DcTpXy8zDjsj-3lQ68'
    && $userinfo['openid'] != 'ohHvIjrnsddgLZLuwK8A3A-HiO_U'
    && $userinfo['openid'] != 'ohHvIjsugIVLA944hQKGkbnuAY6I'
    && $userinfo['openid'] != 'ohHvIjqe8pQk-6rpHdauAx6YLbr0'
    && $userinfo['openid'] != 'ohHvIjg_FswPQU5-0OgwvKMkL9K4'
    && $userinfo['openid'] != 'ohHvIjph_XJHpwyqGhRXtZjJLb18'
    && $userinfo['openid'] != 'ohHvIjkLaAgUFBOLNPmBfAl-tCVE'
    && $userinfo['openid'] != 'ohHvIjoXbdYn99Bt3rAB0hWP91FI'
    && $userinfo['openid'] != 'ohHvIjkK34kVxhV5gapxPDvHKm-Y'
    && $userinfo['openid'] != 'ohHvIjm1HesA1FF5qJRGFINXsHCM'
    && $userinfo['openid'] != 'ohHvIjhN123SM55kv3u_fqDP4mSU'
*/

$studentNo = $userinfo['studentNo'];
$scoreList = $db->get_rows('sdbk_score_20152', array('XH' => $studentNo));

// 计算绩点
$sumScore = 0; // 总学分
$sumPoint = 0; // 总绩点

foreach ($scoreList as $item) {
    $sumScore += $item['XF'];
    $sumPoint += $item['XFJD'];
}

// echo $sumPoint .'/'.$sumScore;

// print_r($scoreList);

$point = number_format($sumPoint / $sumScore, 2);


?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>成绩查询 - 深大百科</title>
    <link href="http://sdkx.qiniudn.com/res/css/common.min.css" rel="stylesheet">
    <link href="http://www.wacxt.cn/score/css/index.css" rel="stylesheet">
</head>
<body>
    <header>
        <p><?php echo $userinfo['studentName']; ?> 同学，你本学期的绩点是：</p>
        <h1><?php echo $point; ?></h1>
        <p class="encourage">下学期再接再厉哦！</p>
    </header>
    <button class="generateBtn" onclick="window.location.href='generate.php'">保存成绩单为图片</button>
    <div class="list">
        <?php foreach ($scoreList as $item):
            $DJCJcss = str_replace('+', 'P', $item['DJCJ']);
        ?>
            <div class="item <?php echo $DJCJcss ?>">
                <div class="itemInfo">
                    <p>课程名：<?php echo $item['KCMC'] ?></p>
                    <p>课程号：<?php echo $item['KCH'] ?></p>
                    <p>学分：<?php echo $item['XF'] ?></p>
                    <p>课程类别：<?php echo $item['KCLB_A'] ?></p>
                    <?php if ($item['SFXX'] && $studentNo > 2015000000): ?>
                        <p>培养方案认定类别：<?php echo $item['SFXX'] ?></p>
                    <?php endif ?>
                </div>
                <div class="itemGrade">
                    <h1><?php echo $item['DJCJ'] ?></h1>
                </div>
                <div style="clear:both"></div>
            </div>
        <?php endforeach ?>
    </div>
    <footer>
        <p>深圳大学教务部 授权</p>
        <p>深圳大学学生事务服务中心 · 深大百科 权威发布</p>
    </footer>
</body>
</html>