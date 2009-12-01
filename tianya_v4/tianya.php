<?php 
include_once './configuration.php';

include_once './GetPg.class.php';

include_once './objects/class.database.php';
include_once './objects/class.pg.php';


$could_insert = true;
$root_dir = 'tianya/';
$fu = '';
$pu = '';
$fv = '';		//base64_encoded
$st = '';		//页面状态：是否固定页面


//取得参数
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
if($fu == ''){
	echo '[need:fu]';
	exit;
}else if($pu == ''){
	echo '[need:pu]';
	exit;
}

$pg_obj = new PG();

$pg_table = array();
$pg_table['name'] = md5($fu);
$pg_table['url'] = base64_encode($pu);
$pg_table['form_vars'] = $fv;

if($st == ''){
	$pg_table['state'] = true;			// 是固定页面
}else{
	$pg_table['state'] = false;
}

$same_list = $pg_obj->GetList(	
	array(
		array('name', '=', $pg_table['name']), 
		array('url', '=', $pg_table['url']), 
		array('form_vars', '=', $pg_table['form_vars'])
	)
);

//判断当前页面是否入库过
if(count($same_list) > 0){
	$could_insert = false;
}

//构造表
if($pg_table['form_vars'] == ''){
	$pg_table['type'] = 1;
	// tianya/2009-12-02/md5($fu)/base64_encode($pu).php
	$pg_table['dir'] = $root_dir.date('Y-m-d').'/'.$pg_table['name'].'/'.$pg_table['url'].'.php';
}else{
	$pg_table['type'] = 2;
	// tianya/2009-12-02/md5($fu)/base64_encode($pu)-$pg_table['form_vars'].php
	$pg_table['dir'] = $root_dir.date('Y-m-d').'/'.$pg_table['name'].'/'.$pg_table['url'].'/'.$pg_table['form_vars'].'.php';
}	

$fid_obj = $pg_obj->GetList(array(array('name', '=', $pg_table['name'])), 'fid', false, 1);
if(count($fid_obj) > 0){
	$pg_table['fid'] = $fid_obj[0]->fid;
}else{
	$fid_last_obj = $pg_obj->GetList(array(), 'fid', false, 1);
	if(count($fid_last_obj) > 0){
		$pg_table['fid'] = $fid_last_obj[0]->fid + 1;
	}else{
		$pg_table['fid'] = 1;
	}
}

$tid_obj = $pg_obj->GetList(array(array('name', '=', $pg_table['name'])), 'tid', false, 1);
if(count($tid_obj) > 0){
	$pg_table['tid'] = $tid_obj[0]->tid + 1;
}else{
	$pg_table['tid'] = 1;
}

if($could_insert){			//没有入库过当前页面
	
	//$pg_table['time'] = date('Y-m-d H:i:s');
	//$pg_table['page_size'] = 0;
	//$pg_table['cache_size'] = 0;
	
	$get_url_cache_obj = new get_url_cache(base64_decode($pg_table['url']), $pg_table['dir'], $pg_table['form_vars']);
	$getpg_st = $get_url_cache_obj->Get(false);	
	
	if($getpg_st[0]){		
		$pg_table['time'] = date('Y-m-d H:i:s', $getpg_st[3]);
		$pg_table['page_size'] = $getpg_st[1];
		$pg_table['cache_size'] = $getpg_st[2];		
		
		//传入数据
		$pg_obj->PG($pg_table['name'], $pg_table['url'], $pg_table['dir'], $pg_table['type'], 
					$pg_table['form_vars'], $pg_table['fid'], $pg_table['tid'], $pg_table['time'], 
					$pg_table['page_size'], $pg_table['cache_size'], $pg_table['state']);
		
		//入库
		$sqlId = $pg_obj->Save();
	}
}else{
	if($same_list[0]->state == false){		//非固定页面
		//$pg_obj->pgId = $same_list[0]->pgId;
		$get_url_cache_obj = new get_url_cache(base64_decode($pg_table['url']), $pg_table['dir'], $pg_table['form_vars']);
		$getpg_st = $get_url_cache_obj->Get(false);	
		
		if($getpg_st[0]){
			//include_once('objects/class.pog_base.php');
			$pog_query = "update `pg` set 
			`time`='".date('Y-m-d H:i:s', $getpg_st[3])."', 
			`page_size`='".$pg_obj->Escape($getpg_st[1])."', 
			`cache_size`='".$pg_obj->Escape($getpg_st[2])."', 
			`state`='".$pg_obj->Escape($pg_table['state'])."' where `pgid`='".$same_list[0]->pgId."'";
			
			echo $connection = Database::Connect();
			$sqlId = Database::InsertOrUpdate($pog_query, $connection);		
		}
	}
}

echo $same_list[0]->pgId;
echo $sqlId;
//创建一个对象的实例
//$get_content_obj = new get_from_url_cache("http://www.google.com", "xx/xx/xxx\as/x/dfsdf/xx.xx/du.html");
       
//$get_content_obj->getURL();

//$get_content_obj->saveCache();
       
//$get_content_obj->getCache();
       
//if($get_content_obj->Get(false)){
       
//}
//$get_content_obj->delCache();









