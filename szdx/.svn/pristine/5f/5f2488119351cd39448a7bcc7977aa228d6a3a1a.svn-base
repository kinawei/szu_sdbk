<?php
header("Content-type: text/html; charset=utf-8");

    include '../libs/mysql.class.php';
    include '../config.php';
    $Mysql = new Mysql();
    
	for($id = 1; $id <= 24; $id++){
        $t = $Mysql->Select('*', 'sdbk_tvote', ' `teacherId` = '.$id);
        //echo "教师名字：".$t['teacherName']."<br>票数：";
        $num = $Mysql->Select_Rows('*', 'sdbk_vote_record', ' `id` = '.$id);
        //echo $num."<br>";
        $vote[$id - 1] = array('name' => $t['teacherName'], 'votenum' => $num);
    }

	$len = count($vote);



	for($i = 0; $i < $len; $i++)
    {
        for($j = $len - 1; $j > $i; $j--)
            if($vote[$j]['votenum'] > $vote[$j-1]['votenum'])
            {//如果是从大到小的话，只要在这里的判断改成if($b[$j]>$b[$j-1])就可以了
                 $x = $vote[$j];
                 $vote[$j] = $vote[$j-1];
                 $vote[$j-1] = $x;
            }
    }
	for($k = 0; $k < $len ; $k++){
        echo "教师名字：".$vote[$k]['name']."<br>票数：".$vote[$k]['votenum']."<br>";
    }


?>