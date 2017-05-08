<?php
if (!isset($_POST['code']) || !isset($_GET['openid']) || empty($_GET['openid'])) {
    header("Location: index.php");
}
/*if ($_GET['openid'] != 'ohHvIjoJeahJQ_e1svpDIv2YAlS4'){
    echo "系统暂时有问题！程序猿紧急修复中！";
    exit();
}*/
session_start();
if (md5($_POST['code']) != $_SESSION['ver']) {
    $err = '验证码错误';
} else {
    unset($_SESSION['ver']);
    include '../config.php';
    include '../libs/mysql.class.php';
    $Mysql = new Mysql();
    $building = $_POST['dormArea'];
    if (isset($_GET['type']) && $_GET['type'] == 2) {
        $roomType = 2;
    } else {
        $roomType = 1;
    }
    $roomname = $_POST['dormId'];
    $result = $Mysql->Select("*", "sdbk_room", "`building` = '".$building."' and `roomname` = ".$roomname);
    if (!$result) {
        $err = '宿舍号不存在';
    } else {
        $roomCode = $result['code'];
        $roomName = $result['roomname'];
        $roomId = $result['roomid'];
        $result = $Mysql->Select("*", "sdbk_room_fee", "`roomcode` = ".$roomCode);
        if (!$result) {
            $getfee = json_decode(file_get_contents("http://cie.szu.edu.cn/antennas/sdbk/df/api.php?roomname=".$roomName."&roomid=".$roomId."&roomtype=".$roomType), true);
            $fee = $getfee['fee'];
            $fee_15days = json_encode($getfee['fee_15days']);
            $updateTime = date("Y-m-d-H", time());
            $result = $Mysql->Insert("sdbk_room_fee", "roomcode,fee,fee_15days,updateTime", $roomCode.",".$fee.",'".$fee_15days."','".$updateTime."'");
            $data = $getfee;
        } else {
            $updateTime = explode('-', $result['updateTime']);
            if ($updateTime[0] == date("Y", time()) && $updateTime[1] == date("m", time()) && $data["fee"] != '') {
                if ($updateTime[2] == date("d", time()) && $updateTime[3] >= 2) {
                    $data = array();
                    $data['fee'] = $result['fee'];
                    $data['fee_15days'] = json_decode($result['fee_15days'], true);
                } else if ($updateTime[2] == (date("d", time()) - 1 ) && $updateTime[3] >= 2 && date("H", time()) <= 2){
                    $data = array();
                    $data['fee'] = $result['fee'];
                    $data['fee_15days'] = json_decode($result['fee_15days'], true);
                }else {
                    $getfee = json_decode(file_get_contents("http://cie.szu.edu.cn/antennas/sdbk/df/api.php?roomname=".$roomName."&roomid=".$roomId."&roomtype=".$roomType), true);
                    $fee = $getfee['fee'];
                    $fee_15days = json_encode($getfee['fee_15days']);
                    $updateTime = date("Y-m-d-H", time());
                    $result = $Mysql->Update("sdbk_room_fee", "fee = {$fee},fee_15days = '{$fee_15days}',updateTime = '{$updateTime}'", "`roomcode` = ".$roomCode);
                    $data = $getfee;
                }
            } else {
                $getfee = json_decode(file_get_contents("http://cie.szu.edu.cn/antennas/sdbk/df/api.php?roomname=".$roomName."&roomid=".$roomId."&roomtype=".$roomType), true);
                $fee = $getfee['fee'];
                $fee_15days = json_encode($getfee['fee_15days']);
                $updateTime = date("Y-m-d-H", time());
                $result = $result = $Mysql->Update("sdbk_room_fee", "fee = {$fee},fee_15days = '{$fee_15days}',updateTime = '{$updateTime}'", "`roomcode` = ".$roomCode);
                $data = $getfee;
            }
        }
    }
}

/**
 * 计算昨日使用电费
 * @param  [double] $day1 [前天]
 * @param  [double] $day2 [昨天]
 * @return [double|bool] [返回差值或者负数为充值电费了]
 */
function calculateYesterdayFee ($day1, $day2)
{
    $using = $day1 - $day2;
    if ($using < 0) {
        return false;
    } else {
        $using = explode('.', round($using, 2));
        $res[0] = $using[0];
        $res[1] = $using[1];
        return $res;
    }
}

/**
 * 平均使用电费
 * @param  [array] $data [前15天用量]
 * @return [type]       [description]
 */
function averageFee ($data)
{
    $allFee = 0.00;
    $days = 0;
    for ($i=0; $i < count($data) - 1; $i++) { 
        if ( $data[$i]['fee'] >= 0 && $data[$i+1]['fee'] >=0 && ( $data[$i+1]['fee'] - $data[$i]['fee'] ) >= 0 ) {
            $allFee += (double)( $data[$i+1]['fee'] - $data[$i]['fee'] );
            $days++;
        }
    }
    $using = explode('.', round($allFee / $days, 2));
    $res[0] = $using[0];
    $res[1] = $using[1];
    return $res;
}

/**
 * 计算剩余可用天数
 * @param  [array] $data [前15天用量]
 * @param  [array] $leftFee [剩余电费]
 * @return [type]       [description]
 */
function availableDays ($data, $leftFee)
{
    $allFee = 0.00;
    $days = 0;
    for ($i=0; $i < count($data) - 1; $i++) { 
        if ( $data[$i]['fee'] >= 0 && $data[$i+1]['fee'] >=0 && ( $data[$i+1]['fee'] - $data[$i]['fee'] ) >= 0 ) {
            $allFee += (double)( $data[$i+1]['fee'] - $data[$i]['fee'] );
            $days++;
        }
    }

    if ($averageFee) {
        $averageFee = $allFee / $days;
        return $availableDays = round(($leftFee / $averageFee), 0);
    } else {
        return 'N/A';
    }
    
}

// var_dump($data);

require_once 'cs.php';
echo '<img src="'._cnzzTrackPageView(1256553865).'" width="0" height="0"/>';
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title><?php echo $building.$roomname ?>用电查询-深大百科</title>
<link href="css/common.min.css" rel="stylesheet">
<link href="css/detail.css?v=12" rel="stylesheet">
</head>
<body>
<?php
    if (isset($err)) {
        echo '  <div class="warning-container">
                    <div class="warning">
                        '.$err.'
                    </div>
                    <div class="confirm">
                        <input type="submit" value="返回" onclick="window.location.href=\'index.php\'" />
                    </div>
                </div>';
        exit();
    }
?>
<header>
    <div class="header-wrapper">
        <div class="header-inner">
            <div class="dashboard">
                <div class="number">
                    <span><?php echo $data['fee']; ?></span>
                </div>
                <div class="tip">剩余电量</div>
            </div>
        </div>
    </div>
</header>
    
<div class="day-container">
    <?php
        $openid = $_GET['openid'];
        $resuleRows = $Mysql->Select_Rows("*", "sdbk_room_warn", "`openid` = '".$openid."' and `roomcode` = ".$roomCode);
        if ($resuleRows == 0) {
            $status = '';
        } else {
            $status = 'enable';
        }
    ?>
    <div class="tools">
        <div class="tools-lowfee-warn">
            低电量提醒
        </div>
        <div class="tools-button <?php echo $status; ?>"></div>
    </div>
    <div class="line1">
        <div class="yesterday">
            <h4>昨日用量</h4>
            <p class="fee">
            <?php
                $using = calculateYesterdayFee($data['fee_15days'][1]['fee'], $data['fee_15days'][0]['fee']);
                if (!$using) {
                    echo "N/A";
                } else {
                    echo $using[0]."<span class=\"decimal\">.".$using[1]."<span class=\"h1tips\"> 度</span></span>";
                }
            ?>
            </p>
        </div>
        <div class="last">
            <h4>预计剩余天数</h4>
            <p class="fee">
            <?php
                $using = availableDays ($data['fee_15days'], $data['fee']);
                if ($using <= 1) {
                    echo "<span class=\"h1tips\">不足 </span>1<span class=\"h1tips\"> 天</span>";
                } else if  ($using > 1) {
                    echo $using."<span class=\"h1tips\"> 天</span></span>";
                } else {
                    echo $using;
                }
            ?>
            </p>
        </div>
    </div>
    <div class="line2">
        <div class="yesterday">
            <h4>每日平均</h4>
            <p class="fee">
            <?php
                $using = averageFee ($data['fee_15days']);
                if (!$using) {
                    echo "N/A";
                } else {
                    echo $using[0]."<span class=\"decimal\">.".$using[1]."<span class=\"h1tips\"> 度</span></span>";
                }
            ?>
            </p>
        </div>
        <div class="last">
            <p style="font-size:12px;text-indent:2em;text-align:justify;color:#F45757;display:none">
            由于学校电费查询系统出错，暂时无法查询到数据，请耐心等待学校修复。
            </p>
            <p style="font-size:12px;text-indent:2em;text-align:justify;color:#777">
            开启低电量提醒，深大百科会根据使用情况，智能分析当剩余电量可使用不足一天时推送消息提醒缴交电费。
            </p>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
    
<div class="days-container hide">
    
</div>

<div class="heightB">
    <p>深大百科团队 · 诚心之作</p>
    <p>Designed and coded by Jason</p>
    <br /><br /><br />
</div>
    
<div class="navbar">
    <div class="day active" onclick="show_today()">
        今日概览
    </div>
    <div class="days" onclick="show_7days()">
        7日概览
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script type="text/javascript">

var today = $(".day"),
    days = $(".days"),
    todayContainer = $(".day-container"),
    daysContainer = $(".days-container"),
    openid = "<?php echo $openid; ?>",
    roomcode = <?php echo $roomCode; ?>;

/*
$("#lowFeeWarn").click(function () {
    $(this).html("<p class=\"h1tips\">尽请期待</p>");
});
*/

today.click(function() {
    today.addClass("active");
    days.removeClass("active");
    todayContainer.removeClass("hide");
    daysContainer.addClass("hide");
});

days.click(function() {
    today.removeClass("active");
    days.addClass("active");
    todayContainer.addClass("hide");
    daysContainer.removeClass("hide");
    //Creat chart
    $(function () {
        $('.days-container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: '<?php echo $building.$roomname ?>  7日剩余电费'
            },
            subtitle: {
                text: 'Source: 内部网电费查询系统'
            },
            xAxis: {
                categories: [
                <?php
                    for ($i = 6 ; $i >= 0; $i--) { 
                        if ($i == 0) {
                            echo '\''.str_replace('-','.',str_replace(date('Y-', time()), '', $data['fee_15days'][$i]['date'])).'\'';
                        } else {
                            echo '\''.str_replace('-','.',str_replace(date('Y-', time()), '', $data['fee_15days'][$i]['date'])).'\',';
                        }
                    }
                ?>
                ]
            },
            yAxis: {
                title: {
                    text: '剩余电量(度)'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br>'+this.x +': '+ this.y +'°C';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '<?php echo $building.$roomname ?>',
                data: [<?php
                    for ($i = 6 ; $i >= 0; $i--) { 
                        if ($i == 0) {
                            echo $data['fee_15days'][$i]['fee'];
                        } else {
                            echo $data['fee_15days'][$i]['fee'].',';
                        }
                    }
                ?>]
            }]
        });
    });
});

$(".tools-button").click(function () {
    $.ajax({
        url: "do.php",
        type: "get",
        data: "roomcode=" + roomcode + "&openid=" + openid,
        dataType: "json",
        success: function(rs){
            if (rs == "true") {
                $(".tools-button").toggleClass("enable");
            }
        }
    });
});

</script>
</body>
</html>