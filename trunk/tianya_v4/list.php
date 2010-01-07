<?php
include_once './configuration.php';
include_once './objects/class.database.php';
include_once './objects/class.info.php';

$channel = '';
$set['one_page_list'] = 20;
$pid = 1;

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
$pid = trim($pid);

//检查参数
if($channel == ''){
	$err['channel'] = 'NULL';
	if($set['show_log'])
		echo json_encode($err);
	exit;
}
if(!($pid >= 1)){
	$err['pid'] = 'ERR';
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
function get_channel_tid($info_obj, $channel_en_name, $pid=1, $limit=false){		//取得某个频道的帖子列表
	global $set;
	$count = $set['one_page_list'];
	$start = ($pid-1)*$count;
	if($limit){
		$pog_query = 
			//"SELECT * FROM `info` WHERE `channel_en` LIKE '".$info_obj->Escape($channel_en_name)."'";
			"SELECT * FROM `info` WHERE `channel_en` LIKE '".$channel_en_name."' limit $start,$count;";
	}else{
		$pog_query = 
			"SELECT * FROM `info` WHERE `channel_en` LIKE '".$channel_en_name."';";
	}
	if(strtolower($channel_en_name) == 'all'){
		$pog_query = 
			"SELECT * FROM `info` limit $start,$count;";
	}
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
function count_channel_tid($info_obj, $channel_en_name){		//取得某个频道的帖子总数
	$pog_query = 
		"SELECT count(*) FROM `info` WHERE `channel_en` LIKE '".$channel_en_name."';";
	if(strtolower($channel_en_name) == 'all'){
		$pog_query = 
			"SELECT count(*) FROM `info` ;";
	}	

	$connection = Database::Connect();
	$rows = Database::Reader($pog_query, $connection);
	$row = Database::Read($rows);
	
	return $row['count(*)'];
}
function get_channel_cn($info_obj, $channel_en){		//取得某个频道的帖子总数
	$pog_query = 
		"SELECT `channel_cn` FROM `info` WHERE `channel_en` LIKE '".$channel_en."' LIMIT 1;";

	$connection = Database::Connect();
	$rows = Database::Reader($pog_query, $connection);
	$row = Database::Read($rows);
	
	//print_r($row);
	return $row['channel_cn'];
}
function gbk2utf8($str){
	return iconv('GBK', 'UTF-8//IGNORE', $str);
}

//构造导航列表
function show_nav($count, $pid){
	global $channel;
	$prev = '';
	if($pid == 1){
		$prev = '&lt;前页';
	}else{
		$prev = '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.($pid-1).'">&lt;前页</a>';
	}
	
	$current = '<span class="thispage">'.$pid.'</span>';
	
	$next = '';
	if($pid == $count){
		$next = '后页&gt;';
	}else{
		$next = '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.($pid+1).'">后页&gt;</a>';
	}
	
	$loop = '';
	$page_loop = 4;
	$page_left = 9;
	$start = $pid - $page_loop;
	if($start < 1){
		$start = 1;
	}
	
	if($start > 4){
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=1">1</a>';
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=2">2</a>';
		$loop .= '<span class="break">···</span>';
	}else if($start == 4){
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=1">1</a>';
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=2">2</a>';
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=3">3</a>';
	}else if($start == 3){
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=1">1</a>';
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=2">2</a>';
	}else if($start == 2){
		$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid=1">1</a>';
	}
	if($count <= $page_loop){
		for($i=1; $i<=$count; $i++){
			if($i == $pid){
				$loop .= $current;
			}else{
				$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.$i.'">'.$i.'</a>';
			}
		}
	}else{
		for($the_pid=$start,$i=1,$run=true; ($i<=$page_left && $run==true); $i++,$the_pid++){
			if($the_pid == $pid){
				$loop .= $current;
			}else{
				$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.$the_pid.'">'.$the_pid.'</a>';
			}
			if(($the_pid+3) >= $count){
				$run = false;
			}
		}

		$the_pid--;
		//echo $count;
		if(($count-2) >= $the_pid){
			if(($the_pid + 1) < ($count-2)){
				$loop .= '<span class="break">•••</span>';
			}else if(($the_pid + 1) == ($count-2)){
				if(($the_pid + 1) == $pid){
					$loop .= $current;
				}else{
					$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.($the_pid+1).'">'.($the_pid+1).'</a>';
				}
			}
		}
		if(($count-1) >= $the_pid){
			if(($count-1) == $pid){
				$loop .= $current;
			}else{
				$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.($count-1).'">'.($count-1).'</a>';
			}
		}
		if($count >= $the_pid){
			if($count == $pid){
				$loop .= $current;
			}else{
				$loop .= '<a href="'.$_SERVER['PHP_SELF'].'?channel='.$channel.'&pid='.$count.'">'.$count.'</a>';
			}
		}
	}
		
$nav = '
<p class="ul"></p>
<div class="paginator">
	<span class="prev">'.$prev.'</span>';
$nav .= $loop;
$nav .= '<span class="next">'.$next.'</span>
</div>
<div class="clearfix" style="border-bottom: 1px solid rgb(204, 204, 204);margin-bottom:0;height:0;">
';

	return $nav;
}

$info_obj = new info();
if($channel == 'index'){
	$channel_r = get_channel($info_obj);
	//print_r($channel_r);
	$list_channel_tid = array();
	foreach($channel_r as $channel_one){
		$channel_en = $channel_one['channel_en'];
		$channel_tid_r = get_channel_tid($info_obj, $channel_en);
		//print_r($channel_tid_r);
		$list_channel_tid[] = $channel_tid_r;
	}
	//print_r($list_channel_tid);
}else{
	$channel_en = $channel;
	$channel_cn = gbk2utf8(get_channel_cn($info_obj, $channel_en));
	$channel_pid_c = count_channel_tid($info_obj, $channel_en);				//总数
	$channel_pid_r = get_channel_tid($info_obj, $channel_en, $pid, true);	
	$channel_pid_p = ceil($channel_pid_c / $set['one_page_list']);
	//print_r($channel_pid_r);
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
        
			<div style="border-bottom: 1px solid rgb(204, 204, 204); " class="clearfix">
				<span class="rr greyinput">
				<?php if($channel != 'index'){ ?>
					<a href="?channel=index">分类浏览</a>
				<?php }else{ ?>
					<span>分类浏览</span>
				<?php } ?>
					&nbsp;/&nbsp;
				<?php if($channel != 'all'){ ?>
					<a href="?channel=all">所有热门标签</a>
				<?php }else{ ?>
					<span>所有热门标签</span>
				<?php } ?>	
				</span>
			</div>
		<?php if($channel == 'index'){ ?>
			<h2 style="padding-top:10px">频道列表 · · · · · · </h2>
		<?php }else{ ?>
			<h2 style="padding-top:10px"><?php echo $channel_cn; ?> · · · · · · </h2>
		<?php } ?>
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
		$td['channel_en'] = $channel_tid[0]['channel_en'];
?>
						<td>
							<a href="?channel=<?php echo $td['channel_en']; ?>"><?php echo $td['channel_cn']; ?></a>
							<b>(<?php echo $td['count']; ?>)</b>
						</td>
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
}else{
	foreach($channel_pid_r as $channel_pid){
		$td['title'] = gbk2utf8($channel_pid['title']);
		$td['author_name'] = gbk2utf8($channel_pid['author_name']);
		$td['time'] = $channel_pid['time'];
		$td['url'] = $channel_pid['name'];
		$td['tid'] = $channel_pid['infoid'];
?>
						<p class="ul"></p>
						<a href="read.php?tid=<?php echo $td['tid']; ?>" target="_blank" title="<?php echo $td['title']; ?>">
							<span style="color:#006600;"><?php echo $td['title']; ?></span>
						</a>
						<a href="<?php echo $td['url']; ?>" target="_blank" title="或零网络"><span>[原帖]</span></a>
						<div class="info">
							<span>[作者:<?php echo $td['author_name']; ?>]</span>
							<span>[整理时间:<?php echo $td['time']; ?>]</span>							
						<div>
					</tr>
					<tr>
<?php
	}
}
?>
					</tr>
				</tbody>
			</table>
<?php 
//分类列表导航
if($channel != 'index'){
	echo show_nav($channel_pid_p, $pid);
}
?>
		</div>
	</div>
</div>

</body>
</html>