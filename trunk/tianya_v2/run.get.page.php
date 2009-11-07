<?php
/*
* @name run.get.page.php
* @description 配合js提交的数据完成采集工作
* @author xami
* @date	20091105
*/
include_once('./Snoopy.class.php');
include_once('./curl.get.php');
include_once('./function.php');
include_once('./get.tianya.page.function.php');


//目标网址
if(isset($_GET['pu'])){
	$page_url = base64_decode(trim($_GET['pu']));
	if(!is_url($page_url)){
		exit;
	}
}else{
	exit;	
}
//echo $page_url;
/*
//主版:1
//副版: json_decode格式
	$submit_vars['apn'] = '101260,110324,124881';
	$submit_vars['intLogo'] = 0;
	$submit_vars['pID'] = 3;
	$submit_vars['rs_permission'] = 1;
*/
if(isset($_GET['channel'])){
	$channel = base64_decode(trim($_GET['channel']));
}else{
	exit;
}
//echo $channel;
/*
//论坛缩写,便于构造网址
if(isset($_GET['forum'])){
	$form_name = base64_decode(trim($_POST['forum']));
}else{
	exit;	
}
*/



	if($channel == 1){
	$collect = new s_collect();
	//$page_gbk = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
	//$page_gbk = $collect->get('http://www.tianya.cn/techforum/content/213/3072.shtml');
	$page_gbk = $collect->get($page_url);
	if($page_gbk == false)
	return false;

	}else{
	$snoopy = new Snoopy;
	// set browser and referer:	
	$snoopy->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
	$snoopy->referer = "http://www.tianya.cn/";
	// set an raw-header:
	$snoopy->rawheaders["Pragma"] = "no-cache";	
			
		$info = json_decode($channel,true);
	//print_r($info);
	//echo 'info';
	/*	
		$submit_vars['apn'] = '101260,110324,124881';
		$submit_vars['intLogo'] = 0;
		$submit_vars['pID'] = 3;
		$submit_vars['rs_permission'] = 1;
	*/	
		/*
		$channel = array(
		"apn" => '101260,110324,124881',
		"intLogo" => '0',
		"pID" => '3',
		"rs_permission" => '1'
		);
		echo json_encode($channel);	
		*/
		if($snoopy->submit($page_url,$info))
		{
			//return $snoopy->results;
			
			$page_gbk = $snoopy->results;	
			//echo $page_gbk;
		}else{
			return  false;
		}	
	}


//$page_gbk = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
//$page_gbk = $collect->get('http://www.tianya.cn/techforum/content/213/3072.shtml');
//$page_gbk = $collect->get($page_addr);
//echo $page_gbk;

/*
//找干扰码 base64_decode(DQqjlKOU);
//echo $page_gbk;
$start_word = iconv('UTF-8', 'GBK', '<div class="content" style="word-wrap: break-word;">');
$end_word = iconv('UTF-8', 'GBK', '<br>');
//echo '||'.get_mid_content($page_gbk, '<div class="content" style="word-wrap: break-word;">', '<br>').'||';
//str_replace($bed_word, '', $page_gbk);
$page_utf8 = iconv('GBK', 'UTF-8//IGNORE', trim($page_gbk));
$cut = get_mid_content($page_gbk, '<DIV class=content style="WORD-WRAP:break-word;">', '<br>');
echo '<p>'.$cut.'</p>';
$s_cut = substr($cut,6);
echo '<p>'.$s_cut.'</p>';
echo '<p>'.iconv('GBK', 'UTF-8//IGNORE', $s_cut).'</p>';
echo '<p>'.base64_encode(substr($cut, 0, 6)).'</p>';
//echo $page_utf8;
//$page_utf8 = iconv('ISO-8859-1', 'UTF-8', trim($page_gbk));
//echo $page_gbk;
//echo $page_utf8;
//$page = $collect->get($page_addr);
//$page_base64 = base64_encode(trim($page_gbk));
//echo $page_base64;
//echo '<pre>';
*/

$str_to_replace = array(base64_decode('DQqj'), base64_decode('lKOU'));
$page_gbk = str_replace($str_to_replace, '', $page_gbk);

$page_utf8 = iconv('GBK', 'UTF-8', trim($page_gbk));

//echo $page_utf8;
if($channel == 1)
	$out = get_content_array($page_utf8, 1);
else
	$out = get_content_array($page_utf8, 2);
//print_r($out);


//echo base64_encode($out);
echo '<pre>';
print_r($out);
echo '</pre>';
//print_r($out[0]['txt']);
//echo substr($out[1],0,2);
//print_r( is_tianya_cn_content($page) );
//print_r( get_pid_list($page,2) );

//echo '</pre>';

?>