<?php
error_reporting(7);

/**
 *  定义摸版根目录
 */
$Templates_root = BASEPATH."templates";
define("Templates",$Templates_root);

/**
 *  定义摸版根目录
 */

$templates  =  ''  ;




/**
 * 装载Smarty.class.php,并实例化对象，在这里将设置Smarty的左右分界符号为<{ 与 }>
 */
include_once('Smarty.class.php');
$tpl = new Smarty();                                  //建立smarty实例对象$smarty

$tpl->debugging = true;
$tpl->template_dir   = Templates."/".$templates;      //设置模板目录

$tpl->compile_dir    = BASEPATH."/cache/".$templates; //设置编译目录
$tpl->cache_dir      = BASEPATH."/cache";             //设置缓存目录
//$tpl->cache_lifetime = 60 * 60 * 24;                //设置缓存时间
$tpl->cache_lifetime = 0;                             //设置缓存时间
$tpl->caching        = false;                         //这里是调试时设为false,发布时请使用true
$tpl->left_delimiter = '<{';
$tpl->right_delimiter= '}>';


$url_From =  trim($_SERVER['QUERY_STRING'])!="" ? "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'] : "http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
$tpl->assign("url_From",      base64_encode($url_From));

if ($_GET[Action]=='phpinfo'){
	phpinfo();
}
?>