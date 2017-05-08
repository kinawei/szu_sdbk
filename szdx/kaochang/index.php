<?php
 
    require 'redis.php';
	include '../libs/mysql.class.php';
	include '../config.php';
	$Mysql = new Mysql();
	header("Content-type: text/html; charset=utf-8"); 
     if (isset($_COOKIE["openid"]) && isset($_COOKIE['secret'])) {
        if ($_COOKIE["secret"] != md5($_COOKIE["openid"])) {
            header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/kaochang"));
            exit();
        }
		$openid = $_COOKIE["openid"];
    } else {
        header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/kaochang"));
        exit();
    }
	
	//$redis = MyRedis::getInstance();
	$redis = RedisManager::getRedisConn();
	$time_out = 30000; // 超时策略: 30秒
	$time_start = time();
	$token = time();
	$tsk_name = 'score';
	$redis->rPush($tsk_name,$token);
 	
    // 堵塞等待队列中第一个和$uuid匹配的(到我了)
	
    while($token != $redis->lGet($tsk_name, 0)){
        if((time()-$time_start)> $time_out) {
            break; // 超时跳出(某些原因队列异常了, 可能永远取不到)
        }
        usleep(10); // sleep 10ms, 再次尝试
    }

	if($redis->lGet($tsk_name, 0) == $token){ // 再次确认第一个是本请求
        $result = $Mysql->Selects('*', 'sdbk_user', ' `openid` = "'.$openid.'"');
  		$userinfo = mysql_fetch_array($result);
        //$redis->incr("sum");
        $redis->lPop($tsk_name); // 完成任务了, 从队列中移除
        if ($userinfo['studentNo'] == 0) {
            header("Location: http://www.wacxt.cn/passport/?redirect_uri=".urlencode("http://www.wacxt.cn/exam"));
            exit();
  		}
        print_r($userinfo);
    }else{ 
        // 出现这种情况, 是因为超时了, 或前面的$uuid没有被消费
        // 若不清除, 后续的请求, 都将无法正常进入队列执行
        // 取队列中的所有$uuid
        $queues = $redis->lRange($tsk_name, 0, -1);
        foreach($queues as $i=>$uid){
            if($uid==$token){ 
                // 队列中仍存在当前的$uuid
                // 清除$uuid以前异常的队列, 让后边的请求得以正常排队
                $redis->lTrim($tsk_name, $i+1, -1);
                break;
            }
        }
    }
    
 