<?php
/*
* @name run.get.page.php
* @description 配合js提交的数据完成采集工作
* @author xami
* @date	20091105
*/
include_once('./curl.get.php');
include_once('./function.php');
include_once('./get.tianya.page.function.php');

//是否正确的网址
function is_url($str){
  return preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/", $str);
}

//目标网址
if(isset($_GET['page'])){
	$page_url = base64_decode(trim($_POST['page']));
	if(!is_url($page_url)){
		exit;
	}
}else{
	exit;	
}

//主版\副版
if(isset($_GET['channel'])){
	$channel = base64_decode(trim($_POST['channel']));
}else{
	exit;	
}

//论坛缩写,便于构造网址
if(isset($_GET['forum'])){
	$form_name = base64_decode(trim($_POST['forum']));
}else{
	exit;	
}

$collect = new s_collect();
//$page_gbk = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
//$page_gbk = $collect->get('http://www.tianya.cn/techforum/content/213/3072.shtml');
$page_gbk = $collect->get($page_addr);
//echo $page_gbk;
$page_utf8 = iconv('GBK', 'UTF-8//IGNORE', trim($page_gbk));
//$page_utf8 = iconv('ISO-8859-1', 'UTF-8', trim($page_gbk));

//echo $page_utf8;
//$page = $collect->get($page_addr);
//$page_base64 = base64_encode(trim($page_gbk));
//echo $page_base64;
//echo '<pre>';

$out = is_tianya_cn_content($page_utf8);
//print_r($out);

//是天涯的帖子
if(is_array($out)){
	$out1 = get_pid_list($page_utf8, $out[0]);
	if(is_array($out1)){
		$out2 = create_url($out1, $out);
	}
}


//echo base64_encode($out);
echo json_encode($out2);
//print_r( is_tianya_cn_content($page) );
//print_r( get_pid_list($page,2) );

//echo '</pre>';
/**/
?>