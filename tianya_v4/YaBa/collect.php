<?php
include_once("./snoopy.class.php");
include_once("./htmlsql.class.php");
require_once("./function.php");
//防止页面超时
set_time_limit(0);
//生成文本文档名称
$name="怒海潜沙";//自定义文件名(注意自己修改)
$txt_name=$name.".txt";
$zhangjie="nu-hai-qian-sha";//这个程序写的并不是很智能，每个章节的链接地址还要自己修改下(注意自己修改)
$max="46";//最大采集章节数(注意自己修改)
$wsql = new htmlsql();
for($i=1;$i<=$max;$i++){
	$a=sprintf("%02d", $i);
	$url="http://www.daomubiji.com/$zhangjie-$a.html";
	// connect to a URL
	if (!$wsql->connect('url', $url)){
		print 'Error while connecting: ' . $wsql->error;
		exit;
	}

	if(!$wsql->query('SELECT * FROM h1')){
		print "Query error: " . $wsql->error; 
		exit;
	}

	// show results:
	foreach($wsql->fetch_array() as $row){
		writeStatistic("\r\n".$row['text']."\r\n",$txt_name);
		$echo=iconv("UTF-8", "GBK", $row['text']);
		//print_r($row);	
	} 

	$wsql->isolate_content('<script src=http://busjs.vodone.cn/bus/ownerjs/advjs_47/47093/47093_56564_p7_.js></script>','<p align="center">');

	if (!$wsql->query('SELECT * FROM *')){
		print "Query error: " . $wsql->error; 
		exit;
	}

	// show results:
	foreach($wsql->fetch_array() as $row){
		writeStatistic(strip_tags($row['text'])."\r\n",$txt_name);
		//print_r($row);	
	}
	print "$i. 章节： $echo 采集完成.....<br>";
	print "--------------------------------------------------------<br>";
	flush();
}
print "卷：$name 全部采集完成......";
?>