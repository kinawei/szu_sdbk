<?php
header('Location: http://www.wacxt.cn/powerusage');
exit();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>用电查询-深大百科</title>
<link media="all" href="http://i.gtimg.cn/vipstyle/frozenui/1.3.0/css/basic.css?bid=2134" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"/>
<link href="css/common.min.css" rel="stylesheet">
<link href="css/index.css" rel="stylesheet">
</head>
<body ontouchstart="" class="body-fight">
<div class="header">
	<h1>请选择宿舍区</h1>
</div>
<div class="wrapper">
    <div id="iSlider-effect-wrapper">
        <div id="animation-effect" class="iSlider-effect">
        </div>
    </div>
</div>
<script src="js/zepto.min.js"></script>
<script src="js/loader.min.js"></script>
<script src="js/template.js"></script>
<script src="js/islider.js"></script>
<script id="cardTemplate" type="text/html">
    <div class="card-wrap animate">
        <div class="card-hd">
            <div class="card-modal">
                <p>我在{{title}}</p>
            </div>
            <div class="card-bg">
                <span style="background-image:url({{bg}})"></span>
            </div>
        </div>
        <div class="card-bd">
            <div class="play-info line-dot">
                <span class="field">{{nick}}</span>
            </div>
	        <a href="dorm.php?dorm={{btnClass}}">
	        	<div class="ui-btn-wrap">
	                <button class="ui-btn-lg">
	                    进入查询
	                </button>
	            </div>
            </a>
        </div>
    </div>
</script>
<script>
    (function (doc, win) {
        var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth>=500 ? 500 : docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 100 * (clientWidth / 375) + 'px';
                };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
    $(function(){
        loading();
        var json=[{
            title: '荔苑社区',
            nick: '以斋为名的宿舍楼群为荔苑社区',
            bg:'http://cdn.www.wacxt.cn/res/images/bg1.jpg',
            btnClass:'zhaiqu'
        },{
            title:'乔苑社区',
            nick:'乔木、乔林、乔森、乔相、乔梧为乔苑社区',
            bg:'http://cdn.www.wacxt.cn/res/images/bg2.jpg',
            btnClass:'qiaoge'
        },{
            title:'西苑社区',
            nick:'西南宿舍除五乔以外的其他宿舍楼群为西苑社区',
            bg:'http://cdn.www.wacxt.cn/res/images/bg3.jpg',
            btnClass:'xinan'
        },{
            title:'南苑社区',
            nick:'南校区的春笛、夏筝、秋瑟、冬筑为南苑社区',
            bg:'http://cdn.www.wacxt.cn/res/images/bg4.jpg',
            btnClass:'nanqu'
        }];

        var data=[],
            extend='',
            res=[],
            devicePixelRatio=window.devicePixelRatio;
        json.forEach(function(item){
            var bg=item['bg'];
            if(devicePixelRatio>=1.5){
                extend='@2x';
                var picType=bg.substring(bg.lastIndexOf(".")+1);
                var picName=bg.substring(0,bg.lastIndexOf("."));
                picName+=extend;
                bg=item['bg']=picName+'.'+picType;
            }
            res.push(bg);
            data.push({'content':template('cardTemplate', item)});
        })

        //预加载资源
        new mo.Loader(res,{
            loadType : 1,
            minTime : 300,
            onLoading : function(count,total){
                //console.log('加载中...（'+count/total*100+'%）');
            },
            onComplete : function(time){
                $('.loading-all').hide();

            }
        })

        function loading(){
            var arr=[1,2,3];
            setInterval(function(){
                var random=Math.floor(Math.random()*3);
                $('.loading-text .step1').removeClass('default-show');
                $('.step'+arr[random]).addClass('show').siblings().removeClass('show');
            },5000);
        }


        var islider1 = new iSlider({
            data: data,
            type:'dom',
            dom: document.getElementById("animation-effect"),
            duration: 2000,
            animateType: 'depth',
            isAutoplay: false,
            isLooping: true
        });
        islider1.addDot();
    })
	function jumpto(link) {
       	window.location.href = "dorm.php?dorm=" + link;
    }
</script>
</body>
</html>