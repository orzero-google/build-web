<?php
/**
* 将内如写入指定文件包
*
* 参数: string $sql : 写入的内容
		string $txt_name : 指定文件名
* 返回: void
* 作用域: public
* 日期: 2007-11-29
*/
function writeStatistic($sql,$txt_name){
	$filename="txt_packet/".$txt_name;//注意修改文件的路径
	if (file_exists($filename)) {
		$fp=fopen($filename,"a");
	}else{
		$fp=fopen($filename,"w");
	}
	
	$text=$sql;
	fwrite($fp,$text);
	fclose($fp);
}
?>