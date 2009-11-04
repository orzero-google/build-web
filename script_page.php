<?php
/*
* @name script_page.php
* @description 取得当前页面信息,为采集做准备
* @author xami
* @date	20091104
*/
include_once('./curl.get.php');
include_once('./function.php');
include_once('./get.tianya.page.function.php');

$page_strlen = strlen($_GET['content']);
$page_low_string = strtolower($_GET['content']);
//var_dump(page_exists($low_string));

$collect = new s_collect();
//$page = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
//$page = $collect->get('http://www.tianya.cn/techforum/content/213/3072.shtml');
$page = iconv('GBK', 'UTF-8',$collect->get($page_low_string));
echo $page;
echo '<pre>';

//print_r( is_tianya_cn_content($page) );
//print_r( get_pid_list($page,2) );

echo '</pre>';
?>