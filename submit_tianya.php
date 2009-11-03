<?php
	include "Snoopy.class.php";
	$snoopy = new Snoopy;
	
	$submit_url = "http://www.tianya.cn/techforum/content/213/3072.shtml";
	
	$submit_vars['apn'] = '101260,110324,124881';
	$submit_vars['intLogo'] = 0;
	$submit_vars['pID'] = 3;
	$submit_vars['rs_permission'] = 1;
		
	if($snoopy->submit($submit_url,$submit_vars))
	{
		//while(list($key,$val) = each($snoopy->headers))
		//	echo $key.": ".$val."<br>\n";
		//echo "<p>\n";
		
		//echo "<PRE>".htmlspecialchars($snoopy->results)."</PRE>\n";
		echo $snoopy->results;
	}
	else
		echo "error fetching document: ".$snoopy->error."\n";

?>