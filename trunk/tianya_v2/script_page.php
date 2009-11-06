<?php
/*
* @name script_page.php
* @description 取得当前页面信息,判断是否为目标网址,为采集做准备,主要工作:构造网址列表
* @author xami
* @date	20091104
*/
include_once('./curl.get.php');
include_once('./function.php');
include_once('./get.tianya.page.function.php');

//$page_strlen = strlen($_GET['content']);
//$page_low_string = strtolower($_GET['content']);
//var_dump(page_exists($low_string));
//print_r($_POST);

$page_addr = base64_decode(trim($_GET['content']));
//echo $_POST['content'];
//echo $page_addr;

$collect = new s_collect();
//$page_gbk = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
//$page_gbk = $collect->get('http://www.tianya.cn/techforum/content/213/3072.shtml');
$page_gbk = $collect->get($page_addr);
//echo $page_gbk;

//去干扰码
$str_to_replace = array(base64_decode('DQqj'), base64_decode('lKOU'));
$page_gbk = str_replace($str_to_replace, '', $page_gbk);

$page_utf8 = iconv('GBK', 'UTF-8', trim($page_gbk));
//$page_utf8 = iconv('ISO-8859-1', 'UTF-8', trim($page_gbk));

//echo $page_utf8;
//$page = $collect->get($page_addr);
//$page_base64 = base64_encode(trim($page_gbk));
//echo $page_base64;
//echo '<pre>';

$out = is_tianya_cn_content($page_utf8);
//print_r($out);

//是天涯的帖子,发送返回信息
if(is_array($out)){
	$out1 = get_pid_list($page_utf8, $out[0]);
	if(is_array($out1)){
		$out2 = create_url($out1, $out);
	}else{
		echo '["is_not_tianya_content"]'; 
		exit;
	}
}


//echo base64_encode($out);
if(isset($out2)){
	echo json_encode(array($out, $out1, $out2));
}else{
	echo '["is_not_tianya_content"]'; 
}
//print_r(array($out, $out1, $out2));
//print_r( json_decode(json_encode(array($out, $out1, $out2))) );
//print_r( is_tianya_cn_content($page) );
//print_r( get_pid_list($page,2) );

//echo '</pre>';


/**/
?>