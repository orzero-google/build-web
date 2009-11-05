<?php
/*
* @name run.get.page.php
* @description 配合js提交的数据完成采集工作
* @out 以帖子为单元的数组
* @author xami
* @date	20091105
*/
include_once('./Snoopy.class.php');
include_once('./function.php');
include_once('./get.tianya.page.function.php');

//是否正确的网址
function is_url($str){
  return preg_match("/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/", $str);
}

//目标网址
if(isset($_POST['page'])){
	$page_url = base64_decode(trim($_POST['page']));
	if(!is_url($page_url)){
		exit;
	}
}else{
	exit;	
}

//如果主版：参数,字符:1;
//如果副版：参数,数组:(apn,intLogo,pID,rs_permission)
if(isset($_POST['channel'])){
	$channel = base64_decode(trim($_POST['channel']));
}else{
	exit;
}

$snoopy = new Snoopy;
// set browser and referer:
$snoopy->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
$snoopy->referer = "http://www.tianya.cn/";
// set an raw-header:
$snoopy->rawheaders["Pragma"] = "no-cache";

if($channel != 1){		//base64_encode(1); 不是主版
	$form_data = $channel;			//解析提交的数据
		
	$submit_vars["apn"] = "amiga";
	$submit_vars["intLogo"] = "Search!";
	$submit_vars["pID"] = "Altavista";
	$submit_vars["rs_permission"] = "rs_permission";
	
	if($snoopy->submit($submit_url,$submit_vars)){
		$page_gbk = $snoopy->results;
		$page_utf8 = iconv('GBK', 'UTF-8//IGNORE', trim($page_gbk));
	}
	
	
	$content_r = get_content_array($page_utf8, 2);
	
}else{
	if($snoopy->fetch($page_url)){
		$page_gbk = $snoopy->results;
		$page_utf8 = iconv('GBK', 'UTF-8//IGNORE', trim($page_gbk));
	}
	$content_r = get_content_array($page_utf8, 1);
}

//返回
echo json_encode($content_r);


?>