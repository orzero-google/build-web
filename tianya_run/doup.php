<?php
include_once 'configuration.php';
include_once $set['root'].'/function/tianya.php';

$fu = '';
$pu = '';
$fv = '';		//base64_encoded
$st = '';		//页面状态：是否固定页面,是否动态
$page = 0;
//$info_id = 0;

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
$fu = trim($fu);
$pu = trim($pu);
$fv = trim($fv);
$st = trim($st);
$page = trim($page);
//$info_id = trim($info_id);

$err = array();
if(!($page>=0)){
	$err['page'] = false;
}
if($fu == ''){
	$err['fu'] = false;
}
if($pu == ''){
	$err['pu'] = false;
}
if($err){
	echo json_encode($err);
	exit;
}


$fv = json_decode($fv, true);

//取得数据,同时更新pg表;
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
	global $set;
	$sqlId = 0;
	$could_insert = true;
	$root_dir = $set['tianya_data'];
	$pg_obj = new PG();

	$pg_table = array();
	//$pg_table['name'] = base64_encode($fu);
	//$pg_table['url'] = base64_encode($pu);
	$pg_table['name'] = $fu;
	$pg_table['url'] = $pu;	
	
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
	//var_dump($same_list);
	
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
	//echo $pg_table['dir'];
	
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
	
	//var_dump($could_insert);
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
			$out['url'] = $pg_table['url'];
			$out['dir'] = $pg_table['dir'];
			$sqlId = $pg_obj->Save();
			$out['id']  = $sqlId;
		}
	}else{
		//不需要再次插入数据库,从缓存取得页面
		$sqlId = $same_list[0]->pgId;
		$old_data_info = $pg_obj->Get($sqlId);
		$pg_table['dir'] = $old_data_info->dir;
		$pg_table['url'] = $old_data_info->url;
		
		//var_dump($same_list[0]->state);
		//重新取得页面,如果正确,则同时更新数据库
		if($same_list[0]->state == false){		//非固定页面,一般最后一页内容可能增加
			//$pg_obj->pgId = $same_list[0]->pgId;
			//$get_url_cache_obj = new get_url_cache(base64_decode($pg_table['url']), $pg_table['dir'], $pg_table['form_vars']);
			$get_url_cache_obj = new get_url_cache($pg_table['url'], $pg_table['dir'], $pg_table['form_vars']);
			$getpg_st = $get_url_cache_obj->Get(false);	
			//var_dump($getpg_st);
			
			if($getpg_st[0]){
				//更新数据库
				$pog_query = "update `pg` set 
				`time`='".date('Y-m-d H:i:s', $getpg_st[3])."', 
				`page_size`='".$pg_obj->Escape($getpg_st[1])."', 
				`cache_size`='".$pg_obj->Escape($getpg_st[2])."', 
				`state`='0' where `pgid`='".$sqlId."'";
				//var_dump($pog_query);
				
				$connection = Database::Connect();
				
				$up_status = Database::Reader($pog_query, $connection);
				if($up_status){
					$out['id']  = $sqlId;
					$out['url'] = $pg_table['url'];
					$out['dir'] = $pg_table['dir'];	
				}
			}
		}else{
			$out['id']  = $sqlId;
			$out['url'] = $pg_table['url'];
			$out['dir'] = $pg_table['dir'];	
		}	
	}
	
	//var_dump($out); 
	if(isset($out['id']) && $out['id'] > 0){
		return $out;
	}else{
		return false;
	}
}

//更新info表;
function up_info_count($fu, $page){
	$info_obj = new info();
	$info_r = $info_obj->GetList(array(array('name', '=', $fu)));
	if($info_r && $info_r[0]->infoId > 0){
		$info_id = $info_r[0]->infoId;
		$info = $info_obj->Get($info_id);
		if($info){
			$info_obj->count = $page;
			$update_id = $info_obj->Save();
			if($update_id == $info_id){
				$out['id'] = $update_id;
				$out['count'] = $page;
				$out['channel_cn'] = $info->channel_cn;
				$out['type'] = $info->type;
				$out['author_name'] = $info->author_name;
				return $out;
			}
		}
	}
	return false;
}

//更新content表
function save_content($content_r,$page){
	//var_dump($content_r);
	$content_obj = new content();
	$content = $content_obj->GetList(
		array(
			array('info_id', '=', $content_r['info_id']),
			array('pg_id', '=', $content_r['pg_id'])
			//array('page_num', '=', $page)
		)
	);
	//var_dump($content);
	
	if(isset($content[0]->page_num)){	//找到原始数据
		if(($content[0]->page_num == $page) && ($content[0]->posts == $content_r['posts'])){
			return $content[0]->contentId;
		}else{
			$content_obj->content(
				$content_r['info_id'], 
				$content_r['pg_id'], 
				$content_r['page_num'], 
				$content_r['channel_cn'], 
				$content_r['url'], 
				$content_r['dir'], 
				$content_r['time'],
				$content_r['posts']
			);
			$content_obj->contentId = $content[0]->contentId;			
		}
	}else{
		$content_obj->content(
			$content_r['info_id'], 
			$content_r['pg_id'], 
			$content_r['page_num'], 
			$content_r['channel_cn'], 
			$content_r['url'], 
			$content_r['dir'], 
			$content_r['time'],
			$content_r['posts']
		);	
	}
	$content_id = $content_obj->Save();
	
	if(isset($content_id) && $content_id > 0){
		return $content_id;
	}
	
	return false;
}
//取得楼主发帖数;
function get_posts($dir, $author_name, $first_second){
	$posts = 0;
	if(file_exists($dir)){
		if($content_gz_cache = gzfile($dir)){                      
			$content = implode('', $content_gz_cache);
			if($first_second == 1){
				$content = get_mid_content($content, '<TABLE id="firstAuthor"', '<div id="adsp_content_banner_2"');				
				$top_name = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');				
				//print_r($content);
				if($top_name == $author_name){
					$posts++;
				}
				$content_cut_tmp = explode('</a>', $content, 2);				
				$content = $content_cut_tmp[1];
				$list_name = get_mid_content_array($content, 'vwriter=', '&idwriter');
				//print_r($list_name);
				foreach($list_name as $the_name){
					if($the_name[0]==1 && $the_name[1] == $author_name){
						$posts++;
					}
				}
			}else if($first_second == 2){
				$content = get_mid_content($content, '<div id="pContentDiv"', '<div id="cttPageDiv1"');
				$list_name = get_mid_content_array($content, ' target=_blank>', '</a>');
				foreach($list_name as $the_name){
					if($the_name[0]==1 && $the_name[1] == $author_name){
						$posts++;
					}
				}
			}
			return $posts;
		}
	}
	return false;
}

$pg_out = do_pg($fu, $pu, $fv, $st);
//var_dump($pg_out);

if($pg_out){
	$up_info_out = up_info_count($fu, $page);
}
//var_dump($up_info_out);

if(isset($up_info_out) && $up_info_out){
	$content_r['info_id']    = $up_info_out['id'];
	$content_r['pg_id']      = $pg_out['id'];
	$content_r['page_num']   = $page;
	$content_r['channel_cn'] = $up_info_out['channel_cn'];
	$content_r['url']        = $pg_out['url'];
	$content_r['dir']        = $pg_out['dir'];
	$content_r['time']       = date('Y-m-d H:i:s');
	$posts = get_posts($content_r['dir'], $up_info_out['author_name'], $up_info_out['type']);
	
	$content_out = false;

	$content_r['posts'] = $posts;
	$content_out = save_content($content_r, $page);
	//var_dump($content_out);
	//print_r($content_r);

	//echo $content_out;
	if($content_out>0){
		//$content['cid'] = $content_out;
		//$content['pid'] = $page;
		//echo json_encode($content);
		echo $page;
	}
	
}


