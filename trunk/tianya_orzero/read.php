<?php
include_once 'configuration.php';
include_once $set['root'].'/class/GetPg.class.php';
include_once $set['root'].'/objects/class.database.php';
include_once $set['root'].'/objects/class.content.php';
include_once $set['root'].'/objects/class.info.php';
include_once $set['root'].'/function/function.base.php';
include_once $set['root'].'/function/tianya.php';

$tid = 0;	//表[content]:	字段[info_id]
$pid = 1; 	//表[content	:	字段[page_num]

define('IS_GPC', get_magic_quotes_gpc());
foreach(array('_GET','_POST') as $_request) {
	foreach($$_request as $_key => $_value) {
		if ($_key{0} != '_') {
			if (IS_GPC) {
				//$_value = s_array($_value);
			}
			$$_key = $_value;
		}
	}
}
$tid = trim($tid);
$pid = trim($pid);

//检查参数:tid必须有且大于1,pid没有则默认为1
$run = array();
$run['get_parameter'] = false;
if((isset($tid) && $tid>0) && (isset($pid) && $pid>0)){
	$run['get_parameter'] = true;
}else{
	$log['err'] = 'Need:tid';
	if($set['show_log'])
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
	//print_r($out);
	if(!empty($out)){
		$dir = $out[0]->dir;		
		if(file_exists($dir)){
			if($content_gz_cache = gzfile($dir)){                      
				$content = implode('', $content_gz_cache);
				$out_content_surl['content'] = $content;
				$out_content_surl['surl'] = $out[0]->url;
				return $out_content_surl;
			}
		}	
	}
	
	return false;
}

function get_sql_info($tid){
	$info_obj = new info();
	$out = $info_obj->Get($tid);
	//print_r($out);
	if(empty($out)){
		return false;
	}else{
		return $out;
	}
}
//取得帖子页面楼主发帖数
function get_sql_posts($tid){
	$content_obj = new content();
	$content_r = $content_obj->GetList(
		array(
			array('info_id', '=', $tid)
		)
	);
	$out = array();
	foreach($content_r as $content){
		$out[$content->page_num] = $content->posts;
	}	
	return $out;
}

if($run['get_parameter']){
	$content_get = get_sql_content($tid, $pid);
	//print_r($content_get);
	$run['content'] = $content_get['content'];
	$run['surl'] =  $content_get['surl'];
	if($run['content']){	//取得缓存的页面
		$run['info'] = get_sql_info($tid);
	}
}
//print_r($run['info']);

//取得回复列表
if(!(isset($run['info']))){
	$log['err'] = 'Need:$run[\'info\']';
	if($set['show_log'])
		echo json_encode($log);
	exit;
}
if($run['info']->type == 1 || $run['info']->type == 2){
	$run['blog_list'] = get_content_array($run['content'], $run['info']->type);
	$run['page'] = $run['info']->count;
}

//开始构造页面
if($run['blog_list']){
	//echo '<pre>'."\n";
	//var_dump($run['info']);
	//var_dump($run['blog_list']);
	//var_dump($run['count']);
	//echo '</pre>'."\n";
	
	echo get_header($run['info'], $run['blog_list'], $tid);
	//print_r($run['blog_list']);
	echo get_body($run['blog_list'],$run['info']);
	$posts_list = get_sql_posts($tid);
	//print_r($posts_list);
	echo get_footer($run['page'], $tid, $pid, $posts_list, $run['surl']);
	
}
