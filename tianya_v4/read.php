<?php
include_once './configuration.php';
include_once './GetPg.class.php';
include_once './objects/class.database.php';
include_once './objects/class.content.php';
include_once './function.base.php';

$tid = 0;	//表[content]:	字段[info_id]
$pid = 0; 	//表[content	:	字段[page_num]
define('IS_GPC', get_magic_quotes_gpc());
foreach(array('_GET','_POST') as $_request) {
	foreach($$_request as $_key => $_value) {
		if ($_key{0} != '_') {
			if (IS_GPC) {
				$_value = s_array($_value);
			}
			$$_key = $_value;
		}
	}
}
//检查参数
if((isset($infoid) && $infoid>0) && (isset($contentid) && $contentid>0)){
	
}else{
	$log['err'] = 'Need:infoid,contentid';
	echo json_encode($log);
	exit;
}

function get_sql_content(){
	$content_obj = new content();
	
}