<?php
include_once("./snoopy.class.php");
include_once("./htmlsql.class.php");
require_once("./function.php");
//��ֹҳ�泬ʱ
set_time_limit(0);
//�����ı��ĵ�����
$name="ŭ��Ǳɳ";//�Զ����ļ���(ע���Լ��޸�)
$txt_name=$name.".txt";
$zhangjie="nu-hai-qian-sha";//�������д�Ĳ����Ǻ����ܣ�ÿ���½ڵ����ӵ�ַ��Ҫ�Լ��޸���(ע���Լ��޸�)
$max="46";//���ɼ��½���(ע���Լ��޸�)
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
	print "$i. �½ڣ� $echo �ɼ����.....<br>";
	print "--------------------------------------------------------<br>";
	flush();
}
print "��$name ȫ���ɼ����......";
?>