<?php
/**
* ������д��ָ���ļ���
*
* ����: string $sql : д�������
		string $txt_name : ָ���ļ���
* ����: void
* ������: public
* ����: 2007-11-29
*/
function writeStatistic($sql,$txt_name){
	$filename="txt_packet/".$txt_name;//ע���޸��ļ���·��
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