<?php
include_once './tianya.php';

$fu = '';
$pu = '';
$fv = '';		//base64_encoded
$st = '';		//页面状态：是否固定页面,是否动态


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
	echo json_encode('[need:fu]');
	exit;
}else if($pu == ''){
	echo json_encode('[need:pu]');
	exit;
}

$fv = json_decode($fv, true);

function do_pg($fu, $pu, $fv, $st){
/**
 * 字段说明
 * pgid: 自增
 * name: base64_encode($fu)
 * url:	 base64_encode($pu)
 * dir: 
 * 		//if($fv == '') dir = tianya/2009-12-02/md5($fu)/base64_encode($pu).php
 * 		//if($fv != '') dir = tianya/2009-12-02/md5($fu)/base64_encode($pu)/md5($pg_table['form_vars']).php
 * 		if($fv == '') dir = tianya/md5($fu)/md5($pu).php
 * 		if($fv != '') dir = tianya/md5($fu)/md5($pu)/md5($pg_table['form_vars']).php
 */
	$sqlId = 0;
	$could_insert = true;
	$root_dir = 'tianya';
	$pg_obj = new PG();

	$pg_table = array();
	//$pg_table['name'] = base64_encode($fu);
	//$pg_table['url'] = base64_encode($pu);
	$pg_table['name'] = trim($fu);
	$pg_table['url'] = trim($pu);	
	
	$pg_table['form_vars'] = $fv;		//数组
	
	$fv_serialize = serialize($fv);

	$fv_md5 = md5($fv_serialize);		//作为文件路径
	$name_md5 = md5($fu);
	$url_md5 = md5($pu);
	
	if(isset($st)){
		if($st == 'fixed'){
			$pg_table['state'] = true;			// 是固定页面
		}else if($st == 'unfixed'){
			$pg_table['state'] = false;
		}else{
			$pg_table['state'] = false;
		}
	}else{
		$pg_table['state'] = false;
	}
	
	$same_list = $pg_obj->GetList(	
		array(
			array('name', '=', $pg_table['name']), 
			array('url', '=', $pg_table['url']), 
			array('form_vars', '=', $fv_serialize)
		)
	);
	
	//判断当前页面是否入库过
	if(count($same_list) > 0){
		$could_insert = false;
	}
	
	//构造表
	if($pg_table['form_vars'] == ''){
		$pg_table['type'] = 1;
		$pg_table['dir'] = $root_dir.'/'.$name_md5.'/'.$url_md5.'.php';
	}else{
		$pg_table['type'] = 2;
		$pg_table['dir'] = $root_dir.'/'.$name_md5.'/'.$url_md5.'/'.$fv_md5.'.php';
	}	
	
	//取得fid,没有则新增
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
	
	//自增tid
	$tid_obj = $pg_obj->GetList(array(array('name', '=', $pg_table['name'])), 'tid', false, 1);
	if(count($tid_obj) > 0){
		$pg_table['tid'] = $tid_obj[0]->tid + 1;
	}else{
		$pg_table['tid'] = 1;
	}
	
	if($could_insert){			//没有入库过当前页面,从原始地址取得网页
		//$get_url_cache_obj = new get_url_cache(base64_decode($pg_table['url']), $pg_table['dir'], $pg_table['form_vars']);
		$get_url_cache_obj = new get_url_cache($pg_table['url'], $pg_table['dir'], $pg_table['form_vars']);
		$getpg_st = $get_url_cache_obj->Get(false);	
		
		if($getpg_st[0]){		
			$pg_table['time'] = date('Y-m-d H:i:s', $getpg_st[3]);
			$pg_table['page_size'] = $getpg_st[1];
			$pg_table['cache_size'] = $getpg_st[2];		
			
			//传入数据
			$pg_obj->PG($pg_table['name'], $pg_table['url'], $pg_table['dir'], $pg_table['type'], 
						$fv_serialize, $pg_table['fid'], $pg_table['tid'], $pg_table['time'], 
						$pg_table['page_size'], $pg_table['cache_size'], $pg_table['state']);
			
			//入库
			$sqlId = $pg_obj->Save();
		}
	}else{
		//不需要再次插入数据库,从缓存取得页面
		$sqlId = $same_list[0]->pgId;
		$old_data_info = $pg_obj->Get($sqlId);
		$pg_table['dir'] = $old_data_info->dir;
		
		//重新取得页面,如果正确,则同时更新数据库
		if($same_list[0]->state == false){		//非固定页面,一般最后一页内容可能增加
			//$pg_obj->pgId = $same_list[0]->pgId;
			//$get_url_cache_obj = new get_url_cache(base64_decode($pg_table['url']), $pg_table['dir'], $pg_table['form_vars']);
			$get_url_cache_obj = new get_url_cache($pg_table['url'], $pg_table['dir'], $pg_table['form_vars']);
			$getpg_st = $get_url_cache_obj->Get(false);	
			
			if($getpg_st[0]){
				//更新数据库
				$pog_query = "update `pg` set 
				`time`='".date('Y-m-d H:i:s', $getpg_st[3])."', 
				`page_size`='".$pg_obj->Escape($getpg_st[1])."', 
				`cache_size`='".$pg_obj->Escape($getpg_st[2])."', 
				`state`='".$pg_obj->Escape($pg_table['state'])."' where `pgid`='".$sqlId."'";
				
				$connection = Database::Connect();
				Database::InsertOrUpdate($pog_query, $connection);
			}
		}	
	}
	
	if($sqlId > 0){
		return $sqlId;
	}else{
		return false;
	}
}


$pg_id = do_pg($fu, $pu, $fv, $st);

