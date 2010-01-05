<?php
include_once './configuration.php';
include_once './GetPg.class.php';
include_once './objects/class.database.php';
include_once './objects/class.content.php';
include_once './objects/class.info.php';
include_once './function.base.php';
include_once './tianya.php';

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
$run = array();
$run['get_parameter'] = false;
if((isset($tid) && $tid>0) && (isset($pid) && $pid>0)){
	$run['get_parameter'] = true;
}else{
	$log['err'] = 'Need:infoid,contentid';
	echo json_encode($log);
	exit;
}

function get_sql_content($tid, $pid){
	$content_obj = new content();
	$out = $content_obj->GetList(
		array(
			array('info_id', '=', $tid),
			array('page_num', '=', $pid)
		)
	);
	
	if(!empty($out)){
		$dir = $out[0]->dir;		
		if(file_exists($dir)){
			if($content_gz_cache = gzfile($dir)){                      
				$content = implode('', $content_gz_cache);
				return $content;
			}
		}	
	}
	
	return false;
}

function get_sql_info($tid){
	$info_obj = new info();
	$out = $info_obj->Get($tid);
	if(empty($out)){
		return false;
	}else{
		return $out;
	}
}

if($run['get_parameter']){
	$run['content'] = get_sql_content($tid, $pid);
	if($run['content']){	//取得缓存的页面
		$run['info'] = get_sql_info($tid);
	}
}

//取得回复列表
if($run['info']->type == 1 || $run['info']->type == 2){
	$run['blog_list'] = get_content_array($run['content'], $run['info']->type);
}

//开始构造页面
if($run['blog_list']){
	//echo '<pre>'."\n";
	//var_dump($run['info']);
	//var_dump($run['blog_list']);
	//echo '</pre>'."\n";
	
	echo get_header($run['info'], $run['blog_list'], $tid);
	//print_r($run['blog_list']);
	echo get_body($run['blog_list'],$run['info']);
	echo get_footer();
}