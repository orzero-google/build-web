<?php
	include "Snoopy.class.php";
	$snoopy = new Snoopy;
	
	$submit_url = "http://www.tianya.cn/new/techforum/Content.asp?idWriter=0&Key=0&idItem=100&idArticle=715413";
	
	//$submit_vars["idItem"] = 148;
	
	//$submit_vars["strItem"] = "开心乐园";
	
	//$submit_vars["chrAuthor"] = "monkey258";
	
	//$submit_vars["idArticle"] = 731330;
	//$submit_vars["strTitle"] = "[开心互动]80年代的课本，真是怀恋死我了(贴图)";
	//$submit_vars["idSign"] = 1;
	$submit_vars["pID"] = 1;
	$submit_vars["apn"] = "11943256,11944674,11947384,11950043,11953953,11961529,11969120,11973355,11982227,12734917,12743525,12749421,12754971,12760196,12764295,12768382,12773838,12780477,12794141,12864082,12899447,12955296,12974325,12985299,13020167,13046595,13087124,13126182,13161421,13209820,13238282,13269593";

		
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