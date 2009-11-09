<?php
/*
* @name run.get.page.php
* @description 采集,返回数据
* @author xami
* @date	20091109
*/


include_once('./Snoopy.class.php');
include_once('./function.php');
include_once('./get.tianya.page.function.php');

//目标网址
if(isset($_GET['pu'])){
	$pu = base64_decode(trim($_GET['pu']));	
	if(!is_url($pu)){
		exit;
	}
}else{
	exit;	
}

//页面信息
/*
 * 例如：
 * {"apn":"83231,83331,86748,91451,102071,104311","intLogo":"0","pID":"3","rs_permission":"1"}
 */
if(isset($_GET['channel'])){
	$channel = base64_decode(trim($_GET['channel']));
	//print_r($channel);
}else{
	exit;
}

//第几页
if(isset($_GET['pn'])){
	$pn = base64_decode(trim($_GET['pn']));
}else{
	exit;
}

//echo $pn,$channel,$pn;

//取得数据
$snoopy = new Snoopy;
// set browser and referer:	
$snoopy->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
$snoopy->referer = "http://www.tianya.cn/";
// set an raw-header:
$snoopy->rawheaders["Pragma"] = "no-cache";	

if($channel == 1){
	if($snoopy->fetch($pu))
	{
		//return $snoopy->results;		
		$page_gbk = $snoopy->results;	
		//echo $page_gbk;
	}else{
		return  false;
	}
}else{
		
	$info = json_decode($channel,true);

	if($snoopy->submit($pu,$info))
	{
		//return $snoopy->results;		
		$page_gbk = $snoopy->results;	
		//echo $page_gbk;
	}else{
		return  false;
	}	
}


/*
 * 先不进行编码转换,防止遇到特殊字符终端,最后结果再转换编码
 *
//去掉特殊字符
$str_to_replace = array(base64_decode('DQqj'), base64_decode('lKOU'));
$page_gbk = str_replace($str_to_replace, '', $page_gbk);
$page_utf8 = iconv('GBK', 'UTF-8', trim($page_gbk));
 */

//echo $page_gbk;
if($channel == 1){
	$out = get_content_array($page_gbk, 1);
}else{
	$out = get_content_array($page_gbk, 2);
//print_r($out);
}


/*
foreach ($out as $rid){
	echo '<p>';
	echo iconv('GBK', 'UTF-8//IGNORE', trim($rid['content']));
	echo '</p>';
}*/

//print_r($out);

//插入数据库
//database server
DEFINE('DB_SERVER', "localhost");

//database login name
DEFINE('DB_USER', "root");
//database login password
DEFINE('DB_PASS', "");

//database name
DEFINE('DB_DATABASE', "tianya_20091109");

//smart to define your table names also
DEFINE('TB_F', "ty_forum");
DEFINE('TB_P', "ty_posts");
DEFINE('TB_R', "ty_reply");

require("Database.class.php");
$db = new Database("server_name", "mysql_user", "mysql_pass", "mysql_database"); 
$db->connect();
$db->query("SET NAME utf8;"); 



$db->close();

?>