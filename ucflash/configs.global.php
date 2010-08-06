<?php
error_reporting(7);
@header("Content-type: text/html; charset=utf-8");
session_cache_limiter('public, must-revalidate');
date_default_timezone_set('PRC');

//session初始化
session_start();
/*
|---------------------------------------------------------------
| PHP ERROR REPORTING LEVEL
|---------------------------------------------------------------
*/
//	error_reporting(E_ALL);

/*
|---------------------------------------------------------------
| SYSTEM Info NAME
|---------------------------------------------------------------
*/
$INFO = array();
//cookie 作用域
//如果不能与论坛同步登录，请设置为 .yourdomain.com 形式
$INFO["cookiedomain"] = '';

//cookie 作用路径
$INFO["cookiepath"] = '/';

//文件存放文件夹名称
$INFO["attachmentspath"] = "attachments";

//缩略图的宽度
/*$INFO["smallpicset"] = array("car"=>array("wid"=>"120","hei"=>"90","ifcut"=>"0")
							,"reveal"=>array("wid"=>"114","hei"=>"75","ifcut"=>"0")
							,"adviser"=>array("wid"=>"120","hei"=>"90","ifcut"=>"0")
							,"decoration"=>array("wid"=>"120","hei"=>"80","ifcut"=>"0"));*/

/*
|---------------------------------------------------------------
| SET THE SERVER PATH
|---------------------------------------------------------------
*/
if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
{
	$system_folder = str_replace("\\", "/", realpath(dirname(__FILE__)));//realpath返回规范化的绝对路径名字
}
/*
|---------------------------------------------------------------
| DEFINE APPLICATION CONSTANTS
|---------------------------------------------------------------
|
| EXT		- 获得文件扩展名
| FCPATH	- 本文件的服务器全路径
| SELF		- 当前文件名称
| BASEPATH	- 当前站点的服务器根路径
| Resource  - 资源文件的路径
|
*/
define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder."/");
define("Resource",BASEPATH."classes/resource");

define('UC_ROOT', dirname(__FILE__).'/');
define('UC_API', 'http://localhost/ucflash');
define('UC_DATADIR', UC_ROOT.'data/');
define('UC_DATAURL', UC_API.'/data');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());

/**
 *  判断当前操作系统类型，以获得路径分割符号
 *  并在这里初始化INCLUDE的路径
 */
$TurnDot  =  substr(PHP_OS, 0, 3) == 'WIN'  ?  ";"  :  ":"  ;
$lib_path=".".$TurnDot.Resource."/Smarty/libs/".$TurnDot.Resource."/Smarty".$TurnDot.Resource."/adodb".$TurnDot.BASEPATH."classes/resource/".$TurnDot.BASEPATH."classes/application/".$TurnDot.BASEPATH."classes/element/".$TurnDot.BASEPATH."config/".$TurnDot.BASEPATH."classes/common/";
/**
 *  定义INCLUDE路径
 */
ini_set("include_path",$lib_path);

?>