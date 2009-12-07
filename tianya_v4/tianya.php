<?php 
include_once './configuration.php';

include_once './GetPg.class.php';

include_once './objects/class.database.php';
include_once './objects/class.pg.php';

include_once './function.php';
/*
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
	echo '[need:fu]';
	exit;
}else if($pu == ''){
	echo '[need:pu]';
	exit;
}

//$pu = 'http://www.tianya.cn/techforum/content/23/623330.shtml';
//$fv = '{"apn":"7085542,7088802,7091987,7097250,7102285,7111655,7121439,7136146,7154363,7167525,7198866,7225166","intLogo":"0","pID":"5","rs_permission":"1"}';

//print_r($fv);
//echo '<br /><br />';
$fv = json_decode($fv, true);
//print_r($fv);
//echo '<br /><br />';


print_r(get_tianya($fu, $pu, $fv, $st));
*/
function get_tianya($fu, $pu, $fv, $st){
/**
 * 字段说明
 * pgid: 自增
 * name: md5($fu)
 * url:	 $pu
 * dir: 
 * 		if($fv == '') dir = tianya/2009-12-02/md5($fu)/base64_encode($pu).php
 * 		if($fv != '') dir = tianya/2009-12-02/md5($fu)/base64_encode($pu)/md5($pg_table['form_vars']).php
 * 
 */
	
	$could_insert = true;
	$root_dir = 'tianya/';	
	$pg_obj = new PG();

	$pg_table = array();
	$pg_table['name'] = md5($fu);
	$pg_table['url'] = base64_encode($pu);
	$pg_table['form_vars'] = $fv;		//数组
	
	$fv_serialize = serialize($fv);
	//print_r(unserialize('a:4:{s:3:"apn";s:95:"7085542,7088802,7091987,7097250,7102285,7111655,7121439,7136146,7154363,7167525,7198866,7225166";s:7:"intLogo";s:1:"0";s:3:"pID";s:1:"3";s:13:"rs_permission";s:1:"1";}'));
	
	//$fv_base64_encode = base64_encode($fv);
	$fv_md5 = md5($fv_serialize);		//作为文件路径
	
	if($st == ''){
		$pg_table['state'] = true;			// 是固定页面
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
		// tianya/2009-12-02/md5($fu)/base64_encode($pu).php
		$pg_table['dir'] = $root_dir.date('Y-m-d').'/'.$pg_table['name'].'/'.$pg_table['url'].'.php';
	}else{
		$pg_table['type'] = 2;
		// tianya/2009-12-02/md5($fu)/base64_encode($pu)/$pg_table['form_vars'].php
		$pg_table['dir'] = $root_dir.date('Y-m-d').'/'.$pg_table['name'].'/'.$pg_table['url'].'/'.$fv_md5.'.php';
	}	
	//echo $pg_table['dir'].'<br />';
	
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
						$fv_serialize, $pg_table['fid'], $pg_table['tid'], $pg_table['time'], 
						$pg_table['page_size'], $pg_table['cache_size'], $pg_table['state']);
			
			//入库
			$sqlId = $pg_obj->Save();
		}
	}else{
		//更新
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
				
				$connection = Database::Connect();
				Database::InsertOrUpdate($pog_query, $connection);		

			}
		}	
		
		//不变
		//print_r($same_list);
		$sqlId = $same_list[0]->pgId;

	}
	
	$pg_now = $pg_obj->Get($sqlId);
	$file_now = new get_url_cache(base64_decode($pg_table['url']), $pg_table['dir'], $pg_table['form_vars']);
	//$file_now = new get_url_cache();
	//$file_now->setFile($pg_table['dir']);
	if($file_now->getCache()){
		$content = $file_now->getContent();
	}else{
		$content = false;
	}
	
	if($fv == ''){
		return array(1, $sqlId, $content);
	}else{
		return array(2, $sqlId, $content);
	}
}


//第三版,取得内容
function get_content_array($page_source, $first_second){
	$rq_str_gbk = iconv('UTF-8', 'GBK', '日期：');
	$fw_str_gbk = iconv('UTF-8', 'GBK', '访问：');
	$to_cut_bf = array('<table', '<TABLE', '<BR><BR>', '<br><br>', '<font', '<FONT');
	
	
	if($first_second == 1){
		$page_source = get_mid_content($page_source, '<TABLE id="firstAuthor"', '</DIV></div>');
		//print_r($page_source);
		$table_cut = explode('<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom></TD>', $page_source);
		$cn = 0;
		
		foreach($table_cut as $content){
			if($cn == 0){
		    	$p_content[$cn]['author_id'] = '';
		    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['time'] = get_bf($fw_str_gbk, $p_content[$cn]['time']); //首页需二次过滤
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<div id="pContentDiv"><DIV class=content style="WORD-WRAP:break-word;">',
		    	'<div id="tianyaBrandSpan1">');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
			}else{
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&vwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&vwriter=', '&idwriter');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'</TD></TR></table>',
		    	'<TABLE cellspacing=0 border=0 bgcolor=');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);			
			}
			$cn++;
		}
		return $p_content;
	}else if($first_second == 2){
		//echo $page_source;
		$page_source = get_mid_content($page_source, 
		'<div id="pContentDiv"><',
		'<div id="cttPageDiv1"');
		$table_cut = explode('<TABLE align=center border=0 cellSpacing=0 width=\'100%\'><TR>', $page_source);
		$cn = 0;
		
		foreach($table_cut as $content){
			if($cn == 0){
		    	$p_content[$cn]['author_id'] = get_mid_content($content, '<a href=http://my.tianya.cn/', ' target=_blank>');
		    	$p_content[$cn]['author'] = get_mid_content($content, ' target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<DIV class=content style="WORD-WRAP:break-word">',
		    	'<div id="tianyaBrandSpan1"></div></DIV>');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
			}else{
		    	$p_content[$cn]['author_id'] = get_mid_content($content, '<a href=http://my.tianya.cn/', ' target=_blank>');
		    	$p_content[$cn]['author'] = get_mid_content($content, ' target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<DIV class=content style="WORD-WRAP:break-word">',
		    	'</DIV>');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);			
			}
			$cn++;
		}
		return $p_content;		
	}
}


function get_header($page_source, $first_second){		
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Google Chart API 中文版 - 开发者指南</title>
	<meta name="author" content="Cloudream (cloudream@gmail.com)" />
	<meta name="keywords" content="Google Chart API, Google图表API, 谷歌图表API" />
	<meta name="description" content="Google Chart API 参考中文版，提供强大的在线图表功能，生成的图表可直接以图片形式嵌入您的网页。调用方服务器无需支持动态语言。" />
	<link rel="stylesheet" type="text/css" href="chartapi.css" />
	<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.lazyload.js"></script>
	<script type="text/javascript" src="chartapi.js"></script>
</head>';
}

function get_footer($page_source, $first_second){		
	return '
<div id="history_panel">
<table>
<thead>
<tr><td class="warning">新版文档翻译中</td></tr>
<tr><td><a href="#contents" scrollto="contents">返回目录</a></td></tr><tr><th>浏览记录</th></tr>
</thead>
</table>
<tbody id="history_list"></tbody>
</div>

</body>
</html>
';
}
//echo $same_list[0]->pgId;
//echo $sqlId;
//创建一个对象的实例
//$get_content_obj = new get_from_url_cache("http://www.google.com", "xx/xx/xxx\as/x/dfsdf/xx.xx/du.html");
       
//$get_content_obj->getURL();

//$get_content_obj->saveCache();
       
//$get_content_obj->getCache();
       
//if($get_content_obj->Get(false)){
       
//}
//$get_content_obj->delCache();









