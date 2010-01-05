<?php
include_once './configuration.php';
include_once './objects/class.database.php';
include_once './objects/class.info.php';

$channel = '';
$set['show_log'] = true;

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
$channel = trim($channel);
//检查参数
if($channel == ''){
	$err['channel'] = 'NULL';
	if($set['show_log'])
		echo json_encode($err);
	exit;
}

//取得数据
function get_channel($info_obj){		//取得所有频道列表
	$pog_query = 
		'SELECT a.* FROM `info` a RIGHT JOIN (
			SELECT MIN(infoid) infoid FROM info GROUP BY `channel_cn`
		) b ON b.infoid = a.infoid 
		WHERE a.infoid IS NOT NULL';
	$connection = Database::Connect();
	$rows = Database::Reader($pog_query, $connection);
	$list = false;
	while ($row = Database::Read($rows)){
		//$list[] = iconv('GBK', 'UTF-8//IGNORE', $row['channel_cn']);
		unset($row['pid_list']);
		$list[] = $row;
		//$list[$i]['channel_cn'] = $row['channel_cn'];
	}
	return $list;
}
function get_channel_tid($info_obj, $channel_en_name){		//取得某个频道的帖子列表
	$pog_query = 
		"SELECT * FROM `info` WHERE `channel_en` LIKE '".$info_obj->Escape($channel_en_name)."'";
	$connection = Database::Connect();
	$rows = Database::Reader($pog_query, $connection);
	$list = false;
	while ($row = Database::Read($rows)){
		//$list[] = iconv('GBK', 'UTF-8//IGNORE', $row['channel_cn']);
		unset($row['pid_list']);
		$list[] = $row;
	}
	return $list;
}
function gbk2utf8($str){
	return iconv('GBK', 'UTF-8//IGNORE', $str);
}

$info_obj = new info();

if($channel == 'index'){
	$channel_r = get_channel($info_obj);
	//print_r($channel_r);
	$list_channel_tid = array();
	foreach($channel_r as $channel){
		$channel_en = $channel['channel_en'];
		$channel_tid_r = get_channel_tid($info_obj, $channel_en);
		//print_r($channel_tid_r);
		$list_channel_tid[] = $channel_tid_r;
	}
	//print_r($list_channel_tid);
}

//构造页面
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络::或零阅读,天涯易读整理,WWW.ORZERO.COM</title>
	<meta name="author" content="www.tianya.cn" />
	<meta name="keywords" content="或零易读,或零阅读,或零小说,或零在线,或零交友,orzero,www.orzero.com,Orzero.com,OrZero.COM" />
	<meta name="description" content="或零易读,或零阅读,或零小说,或零在线" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
	<link type="text/css" href="css/list.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>	
</head>
<body>
    
<div id="content">
	<h1>或零整理帖子</h1>
	<div class="grid-16-8 clearfix">
		<div class="article">
        
			<div style="height:20px; border-bottom: 1px solid rgb(204, 204, 204); padding-bottom: 5px; margin-bottom: 10px;" class="clearfix">
				<span class="rr greyinput">
					分类浏览&nbsp;/&nbsp;<a href="/movie/tag/?view=cloud">所有热门标签</a>
				</span>
			</div>
	        
			<a name="类型"><h2 style="padding-top:10px">频道列表 · · · · · · </h2></a>
			<table class="tagCol">
				<tbody>
					<tr>
<?php
if($channel == 'index'){
	$i = 1;		//循环4次换一个tr标记
	foreach($list_channel_tid as $channel_tid){
		$td['id'] = $channel_tid[0]['infoid'];
		$td['channel_cn'] = gbk2utf8($channel_tid[0]['channel_cn']);
		$td['count'] = count($channel_tid);
?>
						<td><a href="./<?php echo $td['id']; ?>"><?php echo $td['channel_cn']; ?></a><b>(<?php echo $td['count']; ?>)</b></td>
<?php
		if($i >= 4){
			$i = 1;
?>
					</tr>
					<tr>
<?php
		}
		$i++;
	}
}
?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

</body>
</html>