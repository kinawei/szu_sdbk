<?php
if (isset($_GET["ticket"])){
	header("Content-Type: text/json");
	$CASserver = "https://auth.szu.edu.cn/cas.aspx/";                 //深圳大学统一身份认证URL**不能修改**
	$ReturnURL = "http://210.39.2.134/test/cas.php";                  //用户认证后跳回到您的网站，根据实际情况修改
	$user_type = array(
		'01' => '本科生',
		'02' => '研究生',
		'03' => '博士生',
		'04' => '留学生',
		'05' => '教工',
		'07' => '教工家属',
		'08' => '测试人员',
		'11' => '成教学生',
		'12' => '自考生',
		'13' => '工作人员',
		'14' => '离退休教工',
		'16' => '外联办学生',
		'17' => '合作银行',
		'20' => '外籍教师',
		'21' => '博士后',
		'23' => '校友',
		'24' => '校外人员',
		'25' => '校内工作',
		'26' => '校企人员',
		'28' => '交换留学生',
		'29' => '消费卡贵宾',
		'30' => '校外绿色通道',
	);
	$URL = $CASserver . "serviceValidate?ticket=" . $_GET["ticket"] . "&service=". $ReturnURL;
	$test = file_get_contents($URL);
	$userinfo = array();
	$userinfo['status'] = 1;
	$userinfo['data']['studentName']= RegexLog($test, "PName");                 //姓名
	$userinfo['data']['org']= RegexLog($test, "OrgName");         //单位
	$userinfo['data']['sex']= RegexLog($test, "SexName");                       //性别
	$userinfo['data']['studentNo']= RegexLog($test, "StudentNo");               //学号
	$userinfo['data']['icAccount']= RegexLog($test, "ICAccount");               //校园卡号
	$userinfo['data']['personalId']= RegexLog($test, "personalid");             //身份证号
	$userinfo['data']['rankName']= $user_type[RegexLog($test, "RankName")];     //用户类别ID编号
	echo json_encode($userinfo);
}

function RegexLog($xmlString, $subStr){
	preg_match('/<cas:'.$subStr.'>(.*)<\/cas:'.$subStr.'>/i', $xmlString, $matches);
	return $matches[1];
}

?>