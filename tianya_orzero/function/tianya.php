<?php 
if(!(isset($set) && $set['include_config'])){
	exit;
}
include_once $set['root'].'/class/GetPg.class.php';
include_once $set['root'].'/objects/class.database.php';
include_once $set['root'].'/objects/class.pg.php';
include_once $set['root'].'/objects/class.info.php';
include_once $set['root'].'/objects/class.content.php';
include_once $set['root'].'/function/function.base.php';
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
//return: 1, $sqlId, $content
function get_tianya($fu, $pu, $fv, $st){
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
	
	$could_insert = true;
	$root_dir = 'tianya';	
	$pg_obj = new PG();

	$pg_table = array();
	$pg_table['name'] = base64_encode($fu);
	$pg_table['url'] = base64_encode($pu);
	$pg_table['form_vars'] = $fv;		//数组
	
	$fv_serialize = serialize($fv);
	//print_r(unserialize('a:4:{s:3:"apn";s:95:"7085542,7088802,7091987,7097250,7102285,7111655,7121439,7136146,7154363,7167525,7198866,7225166";s:7:"intLogo";s:1:"0";s:3:"pID";s:1:"3";s:13:"rs_permission";s:1:"1";}'));
	
	//$fv_base64_encode = base64_encode($fv);
	$fv_md5 = md5($fv_serialize);		//作为文件路径
	$name_md5 = md5($fu);
	$url_md5 = md5($pu);
	
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
		//$pg_table['dir'] = $root_dir.date('Y-m-d').'/'.$pg_table['name'].'/'.$pg_table['url'].'.php';
		//$pg_table['dir'] = $root_dir.'/'.$pg_table['name'].'/'.$pg_table['url'].'.php';
		$pg_table['dir'] = $root_dir.'/'.$name_md5.'/'.$url_md5.'.php';
	}else{
		$pg_table['type'] = 2;
		// tianya/2009-12-02/md5($fu)/base64_encode($pu)/$pg_table['form_vars'].php
		//$pg_table['dir'] = $root_dir.date('Y-m-d').'/'.$pg_table['name'].'/'.$pg_table['url'].'/'.$fv_md5.'.php';
		//$pg_table['dir'] = $root_dir.'/'.$pg_table['name'].'/'.$pg_table['url'].'/'.$fv_md5.'.php';
		$pg_table['dir'] = $root_dir.'/'.$name_md5.'/'.$url_md5.'/'.$fv_md5.'.php';
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
		//不变
		//print_r($same_list);
		$sqlId = $same_list[0]->pgId;		
		$old_data_info = $pg_obj->Get($sqlId);
		$pg_table['dir'] = $old_data_info->dir;
		
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
//return : author_id, author, time, content
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
		    	$p_content[$cn]['author'] = get_mid_content($content, 'vwriter=', '&idwriter');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'</TD></TR></table>',
		    	'<TABLE cellspacing=0 border=0 bgcolor=');
		    	if($p_content[$cn]['content'] == false){
		    		$content_tmp = explode('</TD></TR></table>', $content);
		    		$p_content[$cn]['content'] = $content_tmp[1];
		    	}
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
	
	return false;
}

/*
function get_header($p_info, $p_content){	
	foreach($p_content as $content){
		$author[] = iconv('GBK', 'UTF-8//IGNORE',$content['author']);
	}	
	$list = implode(', ', $author);

	foreach($p_info as $info){
		$p_info_utf8[] = iconv('GBK', 'UTF-8//IGNORE',$info);
	}	
	$author_md5 = md5($p_info_utf8[6]);
	
	$keywords = '或零网络>或零阅读,'.$p_info_utf8[3].','.$p_info_utf8[2].','.$p_info_utf8[1].','.$p_info_utf8[6].','.$p_info_utf8[4].','.$p_info_utf8[5].',或零易读,或零阅读,或零小说,或零在线';
	$hd = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络>或零阅读,'.$p_info_utf8[3].'</title>
	<meta name="author" content="'.$p_info_utf8[6].'" />
	<meta name="keywords" content="'.$keywords.'" />
	<meta name="description" content="或零易读,或零阅读,或零小说,或零在线,'.$p_info_utf8[3].','.$list.'" />
	<link rel="stylesheet" type="text/css" href="chartapi.css" />
	<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.lazyload.js"></script>
	<script type="text/javascript" src="chartapi.js"></script>
</head>
<body>
<div id="author" value="'.$author_md5.'"></div>
';
	//$header = iconv('GBK', 'UTF-8', $hd);
	return $hd;
}*/
//$p_info:
/*
//是主版则返回:(1,频道英文缩写,频道中文名称,标题,当前页id,作者id,作者名称)
//是副版则返回:(2,频道英文缩写,频道中文名称,标题,当前页id,作者id,作者名称)
function get_header($p_info, $p_content){	
	foreach($p_content as $content){
		$author[] = iconv('GBK', 'UTF-8//IGNORE',$content['author']);
	}	
	$list = implode(', ', $author);

	foreach($p_info as $info){
		$p_info_utf8[] = iconv('GBK', 'UTF-8//IGNORE',$info);
	}	
	$author_md5 = md5($p_info_utf8[6]);
	
	$keywords = '或零网络>或零阅读,'.$p_info_utf8[3].','.$p_info_utf8[2].','.$p_info_utf8[1].','.$p_info_utf8[6].','.$p_info_utf8[4].','.$p_info_utf8[5].',或零易读,或零阅读,或零小说,或零在线';
	$hd = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络::或零阅读,'.$p_info_utf8[3].'</title>
	<meta name="author" content="'.$p_info_utf8[6].'" />
	<meta name="keywords" content="'.$keywords.'" />
	<meta name="description" content="或零易读,或零阅读,或零小说,或零在线,'.$p_info_utf8[3].','.$list.'" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<link type="text/css" href="./chartapi.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>	
	<script type="text/javascript" src="js/tianya.js"></script>	
</head>
<body>
<div id="first_author" name="'.$author_md5.'"></div>
<div id="first_author_id" name="'.$p_info_utf8[5].'"></div>
';
	//$header = iconv('GBK', 'UTF-8', $hd);
	return $hd;
}
*/

//第三版,配合read.php
//是主版则返回:(1,频道英文缩写,频道中文名称,标题,当前页id,作者id,作者名称)
//是副版则返回:(2,频道英文缩写,频道中文名称,标题,当前页id,作者id,作者名称)
function get_header($p_info, $p_content, $tid){
	foreach($p_content as $content){
		$author[] = iconv('GBK', 'UTF-8//IGNORE',$content['author']);
	}	
	$list = implode(', ', $author);

	$p_info->channel_cn = iconv('GBK', 'UTF-8//IGNORE', $p_info->channel_cn);
	$p_info->title = iconv('GBK', 'UTF-8//IGNORE', $p_info->title);
	$p_info->author_name = iconv('GBK', 'UTF-8//IGNORE', $p_info->author_name);
	
	$author_md5 = md5($p_info->author_name);
	
	$keywords = '或零网络,或零阅读,'.$p_info->title.',第'.$tid.'页,'.$p_info->channel_cn
	.','.$p_info->channel_en.','.$p_info->author_name.','.',或零易读,或零阅读,或零小说,或零在线';
	$hd = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络::或零阅读,'.$p_info->title.',[第'.$tid.'页]</title>
	<meta name="author" content="'.$p_info->author_name.'" />
	<meta name="keywords" content="'.$keywords.'" />
	<meta name="description" content="或零易读,或零阅读,或零小说,或零在线,'.$p_info->title.','.$list.'" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<link type="text/css" href="css/read.css" rel="stylesheet" />
	<script src="http://www.google.com/jsapi"></script>
	<script>
  	google.load("jquery", "1.3.2");
  	google.load("jqueryui", "1.7.2");
	</script>
<!--
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
-->
	<script type="text/javascript" src="js/read.min.js"></script>
</head>
<body>

<div id="first_author" name="'.$author_md5.'"></div>
<div id="first_author_id" name="'.$p_info->author_id.'"></div>

';
	//$header = iconv('GBK', 'UTF-8', $hd);
	return $hd;
}
/*
function get_body($p_content){		
	$body = '<div id="wrap">'."\n";
	$body .= '<h3>作者列表<a id="contents" name="contents"></a></h3>';
	$body .= '<p id="content">载入中...</p>'."\n";
	$i=0;

	foreach($p_content as $p){		
		$str_to_replace = array(base64_decode('DQqj'), base64_decode('lKOU'));
		$p['content'] = str_replace($str_to_replace, '', $p['content']);

		$p['content'] = iconv('GBK', 'UTF-8//IGNORE', $p['content']);		
		
		$p['author'] = iconv('GBK', 'UTF-8', $p['author']);
		$p['time'] = iconv('GBK', 'UTF-8', $p['time']);
		
		$author_md5 = md5($p['author']);
		
		$body .= '<div class="section">'."\n";
		$body .= '<h4 tname="'.$author_md5.'" style="display: none;">'."\n"
		.'<div style="width:40%;display:inline;background-color:#ffffff;" class="tool" pname="'.$author_md5.'"><code style="display:inline;" name="'.$author_md5.'">'.$p['author'].'</code></div>'."\n"
		.'<a id="pc_'.$i.'" name="pc_'.$i.'" time="'.$p['time'].'" ></a>'."\n"
		.'<div class="sw" name="'.$author_md5.'"></div>'."\n"
		.'<div class="tools" name="'.$author_md5.'"></div>'."\n"
		.'</h4>'."\n";	
			
		$body .= '<div cname="'.$author_md5.'" class="scrap" style="display: none;">'."\n".trim($p['content'])."\n".'</div>'."\n";
		$body .= '</div>'."\n\n";
		$i++;
	}	
	
	$body .= '</div>'."\n\n";
	
	return $body;
}*/
/*
function get_body($p_content,$p_info){		
	foreach($p_info as $info){
		$p_info_utf8[] = iconv('GBK', 'UTF-8//IGNORE',$info);
	}
	
	$body = '<div id="wrap">'."\n";
	
	$body .= '<h3><span>作者列表</span><a id="content" name="content"></a></h3>';
	$body .= '<p id="contents" name="contents">载入中...</p>'."\n";
	
	$i=0;
	foreach($p_content as $p){		
		$str_to_replace = array(base64_decode('DQqj'), base64_decode('lKOU'));
		$p['content'] = str_replace($str_to_replace, '', $p['content']);
		$p['content'] = iconv('GBK', 'UTF-8//IGNORE', $p['content']);		
		$p['author'] = iconv('GBK', 'UTF-8', $p['author']);
		if($p['author_id'] == $p_info_utf8[5]){
			$p['author'] = $p_info_utf8[6];
			//echo $p_info_utf8[6];
		}
		$p['time'] = iconv('GBK', 'UTF-8', $p['time']);		
		$author_md5 = md5($p['author']);
		
		$body .= '<div class="section" aid="'.$p['author_id'].'">'."\n";
		
		$body .= '<h4 class="blog_author" name="'.$author_md5.'">';
			$body .= '<span>'.$p['author'].'</span><a name="'.'blog_'.$i.'"></a><div class="close"></div><div class="tools"></div>';
		$body .= '</h4>'."\n";		
		$body .= '<div class="blog" name="'.$author_md5.'" bid="'.'blog_'.$i.'">'."\n".trim($p['content'])."\n".'</div>'."\n";
		
		$body .= '</div>'."\n\n";
		$i++;
	}	
	
	$body .= '</div>'."\n\n";
	
	//$body .= '<div id="count" value="'.$i.'"></div>'."\n";
	
	return $body;
}
*/
//第三版,配合read.php
function get_body($p_content, $p_info){			
	$body = '';
	$content = '';
	$i=0;
	foreach($p_content as $p){		
		$str_to_replace = array(base64_decode('DQqj'), base64_decode('lKOU'));
		$p['content'] = str_replace($str_to_replace, '', $p['content']);
		$p['content'] = iconv('GBK', 'UTF-8//IGNORE', $p['content']);		
		$p['author'] = iconv('GBK', 'UTF-8', $p['author']);
		if($p['author_id'] == $p_info->author_id && $p_info->author_id != 0){
			$p['author'] = $p_info->author_name;
			//echo $p_info_utf8[6];
		}
		$p['time'] = iconv('GBK', 'UTF-8', $p['time']);		
		$author_md5 = md5($p['author']);
		
		//$content .= '<li name="'.$author_md5.'" style="display:inline">' . $p['author']
        //	. '<a href="#'.'blog_'.$i.'" scrollto="'.'blog_'.$i.'"></a></li>'."\n";
		$content .= '<li name="'.$author_md5.'" style="display:inline">' . $p['author']
        	. '<a href="#'.'blog_'.$i.'" scrollto="'.'blog_'.$i.'"></a></li>';
        	
		$body .= '<div class="section" aid="'.$p['author_id'].'" name="'.$author_md5.'">'."\n";
		$body .= '<h4 class="blog_author" name="'.$author_md5.'">';
		$body .= '<span style="float:left;" class="fopen fshow ui-icon ui-icon-folder-collapsed"></span><span class="fopen">'.$p['author'].'</span><a name="'.'blog_'.$i.'"></a><div class="close"></div><div class="tools"></div>';
		$body .= '</h4>'."\n";
		$body .= '<div class="blog" name="'.$author_md5.'" bid="'.'blog_'.$i.'">'."\n".trim($p['content'])."\n".'</div>'."\n";
		$body .= '</div>'."\n\n";
		$i++;
	}
	
	$list = '<div id="list" style="display:none;">'."\n"
			//.'<h3><span class="name"></span><a id="list_h" name="list_h"></a></h3>'."\n"
			.'<div id="lists" name="lists"><ol>'."\n"
			.$content."\n"
			.'</ol></div>'."\n"
			.'</div>'."\n\n";
	
	$wrap = '<div id="wrap">'."\n"
			//.'<h3><span>作者列表</span><a id="content" name="content"></a></h3>'
			//.'<p id="contents" name="contents">载入中......</p>'."\n"
			//.'<p id="contents" name="contents"><ol>'."\n".$content.'</ol></p>'."\n\n"
			.$body
			.'</div>'."\n\n";
	//$body .= '<div id="count" value="'.$i.'"></div>'."\n";	
	return $list.$wrap;
}

function get_footer($page_count, $tid, $pid, $posts_list, $s_url){		
$ft = '

<div id="tools_panel" style="display:none;width:140px;right:0;top:100px;+position:absolute;+top:expression(eval(document.body.scrollTop)+100);">
<table>
	<thead style="font-size:14px;">
		<tr><td class="warning" style="text-align:center;">工具栏<a title="或零整理帖子" target="_blank" href="http://www.orzero.net/2010/01/%E5%A4%A9%E6%B6%AF%E6%98%93%E8%AF%BB%E6%95%B4%E7%90%86.html"><span style="font-size:12px;text-decoration:underline;color:#666666;">[问题反馈]</span></a></td></tr>
		<tr><th class="qj" style="text-align:center;">全局功能</th></tr>
		<tr><td class="qj lz"><span style="float:left;" class="ui-icon ui-icon-lightbulb"></span>显示楼主帖子</td></tr>
		<tr><td class="qj allzz"><span style="float:left;" class="open ui-icon ui-icon-gear"></span>打开全部作者</td></tr>
		<tr><td class="qj show_list"><span style="float:left;" class="ui-icon ui-icon-newwin"></span>显示作者列表</td></tr>
		<tr><th class="dh" style="font-size:12px;text-align:center;">导航功能<a href="'.$s_url.'" target="_blank" title="或零网络"><span style="font-size:12px;">[原帖]</span></a><br /><span style="font-size:12px;color:#A4A4A4;">(总'.$page_count.'页)</span></th></tr>
		<tr>
			<td class="dh" style="font-size:12px;text-align:center;padding-left:1px;padding-top:9px;padding-right:1px;padding-bottom:9px;">
				<span title="打开前一页" class="prev">&lt;前页</span>&nbsp;<span title="当前页" class="current">[第'.$pid.'页]</span>&nbsp;<span title="打开后一页" class="next">后页&gt;</span>
			</td>
		</tr>
	</thead>
</table>
</div>

';

$ft .= '
<div id="page_info" tid="'.$tid.'" pid="'.$pid.'" count="'.$page_count.'">
';
for($i=1; $i<=$page_count; $i++){
	$style = 'style="font-size:14px;line-height:1.3;padding-top:2px;padding-bottom:2px;background:#DEE7F8;"';
	if($posts_list[$i] > 0){
		$style = 'style="font-size:14px;line-height:1.3;padding-top:2px;padding-bottom:2px;background:#90EE90;"';
	}
	
	$ft .= "\t".'<a class="jump" pid="'.$i.'" title="或零整理帖子" href="?tid='.$tid.'&pid='.$i.'"><span '.$style.'>第'.$i.'页('.$posts_list[$i].')</span></a>'."\n";
}
$ft .= '
</div>

<div id="err"></div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-12384675-1");
pageTracker._setLocalRemoteServerMode();
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>
';
	
	return $ft;
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


//判断是否是天涯的内容帖子,同时返回：
//是主版则返回:(1,频道英文缩写,频道中文名称,标题,当前页id,作者id,作者名称)
//是副版则返回:(2,频道英文缩写,频道中文名称,标题,当前页id,作者id,作者名称)
function is_tianya_cn_content($page_source){
	$info = array();
 	//主版
    $channel = get_mid_content($page_source, 'var strItem="', '";');
    if($channel != null){
	    $content_flag = get_mid_content_array($page_source, '<span class="lb12">', '</span>');
	    //print_r( $content_flag );      
	    $forum_name = get_mid_content($page_source, '" class="lb12">', '</a>');
	    //$article_name = Snoopy::_striptext(get_mid_content($page_source, 'var chrTitle = "', '";'));
	    $article_name_cut = get_mid_content($page_source, 'var chrTitle = "', '";');
	    //echo $article_name_cut;
	    $article_name = preg_replace("'<[^<>]*>'i", '', $article_name_cut);
	    //echo $article_name;
	    //echo $article_name;
	    $article_id = get_mid_content($page_source, 'var idArticle="', '";');	    
	    //echo $channel;   
	    $blog_author = get_mid_content($page_source, 'var chrAuthorName = "', '";');
	    if($blog_author != false){
	    	$cut_temp = explode('&vwriter='.$blog_author.'&idwriter=0&key=0', $page_source, 2);
	    	if(isset($cut_temp[1])){
		    	$id_str = substr($cut_temp[0], -20, 20);	    	
		    	$cut_id_temp = explode('vid=', $id_str);
		    	$blog_author_id = $cut_id_temp[1];
	    	}else{
	    		$blog_author_id = 0;
	    	}
	    }
	    if(!is_numeric($blog_author_id)){
	    	$blog_author_id = '';
	    }
	    if( (count($content_flag) == 3) && ($content_flag[0][0] == 0) && ($content_flag[1][0] == 1) && ($content_flag[2][0] == 1) ){
	        if( isset($channel) ){
	            //return array('first_second'=>1, 'channel'=>$channel, 'form_name'=>$forum_name); 
	            //echo '<pre>';
	            //print_r( array(1, $channel, $forum_name, $article_name, $article_id) );
	            //return array(1, $channel, $forum_name, $article_name, $article_id, $blog_author_id, $blog_author); 
	            $info['type']  = 1;
	            $info['ch_en'] = $channel;
	            $info['ch_cn'] = $forum_name;
	            $info['title'] = $article_name;
	            $info['pid']   = $article_id;
	            $info['aid']   = $blog_author_id;
	            $info['aname'] = $blog_author;
	            return $info;            
	        }
	    }
	  }
	//副版
    $channel = get_mid_content($page_source, 'var idItem="', '";');
    if($channel != null){
    	$content_flag = '';
	    $content_flag = get_mid_content_array($page_source, '<span class="lb12">', '</span>');
	    //print_r( $content_flag ); 
	    $forum_name = '';
	    $forum_name = get_mid_content($page_source, '" class="lb12">', '</a>');
	    $article_name = get_mid_content($page_source, 'var chrTitle = "', '";');
	    $article_name = preg_replace("'<[^<>]*>'i", '', $article_name);
	    $article_id = get_mid_content($page_source, 'var idArticle="', '";');
	    //echo $channel;   
	    $blog_author_id = get_mid_content($page_source, 'var intAuthorId = "', '";');
	    $blog_author = get_mid_content($page_source, 'var chrAuthorName = "', '";');
	    if( (count($content_flag) == 3) && ($content_flag[0][0] == 0) && ($content_flag[1][0] == 1) && ($content_flag[2][0] == 1) ){
	        if( isset($channel) ){
	            //return array('first_second'=>2, 'channel'=>$channel, 'form_name'=>$forum_name);  
	            //return array(2, $channel, $forum_name, $article_name, $article_id, $blog_author_id, $blog_author);
	            $info['type']  = 2;
	            $info['ch_en'] = $channel;
	            $info['ch_cn'] = $forum_name;
	            $info['title'] = $article_name;
	            $info['pid']   = $article_id;
	            $info['aid']   = $blog_author_id;
	            $info['aname'] = $blog_author;
	            return $info;
	        }
	    }
	  }
	  
	return false;   
}
//取得导航部分
function get_pid_list($page_source, $first_second){
	if($first_second == 1){
    $nav = get_mid_content($page_source, '<!-- google_ad_section_start -->', '<table border="0" align="center" cellspacing="0" width="100%">');   
    if($nav == null){        //只有首页
        return false;   
    }
    $pid_list_str = get_mid_content($nav, '<input type=\'hidden\' name=\'idArticleslist\' value=\'', ',\'>');
    $pid_list_array = explode(',', $pid_list_str);
    //print_r( $pid_list_array );
    
	if($pid_list_array[0] == null){
		$pid_list_array[0] = get_mid_content($page_source, 'var idArticle="', '";');
	}	    
    return $pid_list_array;
  }else if($first_second == 2){
  	$pid_list_str = get_mid_content($page_source, '<input type="hidden" name="apn" value="', '">');
  	$pid_list_array = explode(',', $pid_list_str);
  	return $pid_list_array;
  }
  return false;
}

//创建连接
function mk_link_list($url, $is_tianya, $pid_list){
	$pid_str = implode(',', $pid_list);
	if($is_tianya['type'] == 1){		
		$i = 0;
		foreach($pid_list as $pid){
			$get[$i]['fu'] = 'http://www.tianya.cn/publicforum/content/'.$is_tianya['ch_en'].'/1/'.$pid_list[0].'.shtml';
			$get[$i]['pu'] = 'http://www.tianya.cn/publicforum/content/'.$is_tianya['ch_en'].'/1/'.$pid.'.shtml';
			$get[$i]['fv'] = '';
			$get[$i]['st'] = 'fixed';
			$i++;
		}
  		$get[($i -1)]['st'] = 'unfixed';
  		return $get;		
	}else if($is_tianya['type'] == 2){ 		
  		$i = 0;
  		$get = array();
  		foreach($pid_list as $pid){
  			$get[$i]['fu'] = $url;
  			$get[$i]['pu'] = $url;
  			$get[$i]['fv'] = '{"apn":"'.$pid_str.'","intLogo":"0","pID":"'.($i+1).'","rs_permission":"1"}';
  			$get[$i]['st'] = 'fixed';
  			$i++;
  		}	
  		$get[($i -1)]['st'] = 'unfixed';
  		return $get;
	}
  return false;
}









