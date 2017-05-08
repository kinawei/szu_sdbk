<?php
//die('暂未开放');
include '../libs/mysql.class.php';
include '../config.php';
$Mysql = new Mysql();
//szdx.sinaapp.com
if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
	if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
		header("Location: http:/www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/vote"));
  	}
  	$openid = $_COOKIE["openid"];
  	$result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
  	$userinfo = mysql_fetch_array($result);
  	if ($userinfo['studentNo'] == 0) {
  		header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http:/www.wacxt.cn/vote"));
  	}
} else {
    header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/vote"));
}

$openid = $userinfo['openid'];
$teacherRes = $Mysql->Selects('*', 'sdbk_tvote', '');

/*if($userinfo['rankName'] != '本科生' && $userinfo['rankName'] != '研究生'&& $userinfo['rankName'] != '交换留学生'&& $userinfo['rankName'] != '自考生'   && $userinfo['rankName'] != '教工' && $userinfo['rankName'] != '博士生' && $userinfo['rankName'] != '博士后'){
    exit("本次投票仅限于深大学生和教工参与。");
}*/
if(!($userinfo['studentNo'])){
	exit("本次投票仅限于深大学生和教工参与。");
}

?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>深圳大学2016年本科生辅导员网络人气投票-深大百科</title>
<link href="http://cdn.www.wacxt.cn/res/css/common.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="css/index.css?v=8" rel="stylesheet">
</head>
<body>
<img src="image/top.jpg?v=1" class="topImg">
<div class="voteRuleContainer">
    <div class="voteRule">
        <h3>【投票说明】</h3>
        <p>1.投票时间：2016年12月16日12时至12月23日12时。</p>
        <p>2.投票规则：每人限投3位候选人，投票超过或少于3位均为无效票。</p>
        <p>3.计票方式：按得票多少排序。计票结果排名前四名作为深圳大学2016最具人气本科生辅导员获奖人报学校批准。</p>
        <!--<p>4.本次投票将在23日抽选出幸运儿，送出礼品。</p>
        <p>具体奖励请点击：<a href="http://mp.weixin.qq.com/s?__biz=MjM5NTUwMzQ5Mg==&mid=401825324&idx=1&sn=42fa6ffbe51eb373b8f657814e416b7e#rd">投票幸运奖品介绍</a></p>-->
        <!--<p>5.本次活动解释权归深圳大学学生部所有。</p>-->
    </div>
</div>
<!--
    <h1 class="warning">根据投票工作安排，现暂时屏蔽具体票数，请继续踊跃投票支持各位辅导员老师</h1>
    -->
<?php
$voteTotal = 0;
$i = 0;
while ($teacher[$i] = mysql_fetch_array($teacherRes)) {
    $teacher[$i]['teacherBallot'] = $Mysql->Select_Rows('*', 'sdbk_vote_record', '`id` = '.$teacher[$i]['teacherId']);
    if (mb_strlen(strip_tags($teacher[$i]['teacherDes']), 'UTF-8') > 32) {
        $teacher[$i]['teacherDes'] = mb_substr(strip_tags($teacher[$i]['teacherDes']), 0, 32,"UTF-8");
        $teacher[$i]['teacherDes'] .= "...";
    }
    $i++;
}
//var_dump($teacher);
array_pop($teacher);
shuffle($teacher);
for ($j=0; $j < count($teacher); $j++) { 
?> 
    <div class="votePartContainer" style="padding:20px 20px 10px 35px">
    <div class="votePart">
        <div class="chooseActive">
            <i class="fa fa-check"></i>
        </div>
        <img class="headimg" src="http://cdn.szdx.sinaapp.com/image/participant/<?php echo $teacher[$j]['teacherId'] ?>.jpg?v=1" data-id="<?php echo $teacher[$j]['teacherId'] ?>" height="150px" >
        <div class="votePartTeacherName">
            <p>支持TA<span class="small">(<?php echo $teacher[$j]['teacherBallot'];?>票)</span></p>
        </div>
        <a href="detail.php?id=<?php echo $teacher[$j]['teacherId'] ?>">
            <div class="votePartDes">
                <p>
                    <?php echo $teacher[$j]['teacherName'] ?>
                    <br />
                    <?php echo $teacher[$j]['teacherCollege'] ?>
                    <br />
                    <br />
                    <span class="btn">查看简介</span>
                </p>
            </div>
        </a>
    </div>
</div>
<?php
}
?>

<div class="mask">
    <div class="loadTips">
        <h1><i class="fa tipsicon fa-circle-o-notch"></i></h1>
        <p class="tips">提交中，请稍候...</p>
    </div>
</div>
<div class="author">
    <p></p>
</div>
<?php
$voteNum = $Mysql->Select_Rows('*', 'sdbk_vote_record', "`openid` = '".$openid."'");
if ($voteNum > 0) {
    $voted = $voteNum;
    $voteBtn = "已提交";
} else {
    $voted = 0;
    $voteBtn = "提&nbsp;交";
}
?>
<footer>
    <p>限选3人，已选<span class="checkedNum"><?php echo $voted; ?></span>人</p>
    <!-- Standard button -->
<!--	<button id="submit" type="button" class="btn btn-default">提交</button> -->
    <n>
</footer>
<script src="//cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
var voteNum = 0,
    openid = '<?php echo $openid ?>',
    vote = [],
    voted = <?php echo $voted ?>;
    headimg = $(".headimg"),
    checkedNum = $(".checkedNum"),
    submitBtn = $("#submit");
    mask = $(".mask");

headimg.click(function () {
    if (voted) {
        return;
    }
    id = $(this).data('id');
    if (vote.indexOf(id) == -1) {
        if (voteNum >= 3) {
            alert("限选3人哦！");
            return;
        }
        vote.push(id);
        voteNum++;
    } else {
        vote.splice(vote.indexOf(id), 1);
        voteNum--;
    }
    //console.log(vote);
    console.log($(this).parent('.votePart').width());
    $(this).parent('.votePart').toggleClass("votePartActive");
    console.log($(this).parent('.votePart').width());
    checkedNum.text(voteNum);
});
submitBtn.click(function () {
    if (voted) {
        alert("你已经投过票了！");
        return;
    }
    if (voteNum != 3) {
        alert("一定要选满3个人哦！");
        return;
    }
    mask.show();
    $.ajax({
        url: 'vote.php',
        dataType: 'json',
        type: 'get',
        data: {
            openid : openid,
            id : vote.join(',')
        },
        success: function (rs) {
            if (rs['status'] == 0) {
                $(".tipsicon").toggleClass("fa-circle-o-notch");
                $(".tipsicon").toggleClass("fa-check");
                $(".tips").text("提交成功！感谢支持！");
                setTimeout("window.location.reload()", 1000);
            }
        }
    });
});
</script>
</body>
</html>