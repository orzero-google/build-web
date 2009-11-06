<?php
	include_once("./Snoopy.class.php");
	$snoopy = new Snoopy;
	// set browser and referer:	
	$snoopy->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
	$snoopy->referer = "http://www.baidu.com/";
	// set an raw-header:
	$snoopy->rawheaders["Pragma"] = "no-cache";	
	
	$first_second = 2;
if($first_second == 2){
	$submit_url = "http://www.tianya.cn/";
	
	$submit_vars['apn'] = '101260,110324,124881';
	$submit_vars['intLogo'] = 0;
	$submit_vars['pID'] = 3;
	$submit_vars['rs_permission'] = 1;
	
	if($snoopy->submit($submit_url,$submit_vars))
	{
		echo $snoopy->results;
		print_r($snoopy->headers) ;
	}else{
		echo $snoopy->headers;
		return  false;
	}
}else if($first_second == 1){
	
}
?>