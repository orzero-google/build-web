<?php
/**
 * 先判断页面类型，主版还是副版
 * 接着提取导航数据
 */
include_once './GetPg.class.php';
include_once './tianya.php';


$url = '';
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

echo '<pre>';
if($url != ''){
	$page_obj = new get_url_cache($url);
	$page_obj->getURL();
	$content = $page_obj->getContent();
	$nav = is_tianya_cn_content($content);
	print_r($nav);
	
	$pid = get_pid_list($content, $nav[0]);
	print_r($pid);
	
	$link = mk_link_list($url, $nav, $pid);
	print_r($link);
	
}else{
	echo '[need:url]';
}

