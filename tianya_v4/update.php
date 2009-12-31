<?php
/**
 * 先判断页面类型，主版还是副版
 * 接着提取导航数据
 */
include_once './GetPg.class.php';
include_once './tianya.php';
include_once './objects/class.info.php';

$show = false;		//成功取得内容后置为真
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
$url = trim($url);


function do_info($url, $info_r, $pid_list_r){
	$info_id = 0;
	$count = 0;	//整理到的页号
	//$name = base64_encode($url);
	$name = $url;
	$info_obj = new info();
	$pid_list_s = serialize($pid_list_r);
	
	$info_old = $info_obj->GetList(array(array('name', '=', $name)), 'infoId', false, 1);
	//print_r($info_old);
	if(empty($info_old)){	//没有找到数据,插入
		$tianya_info['name'] = $name;
		$tianya_info['type'] = $info_r['type'];
		$tianya_info['channel_en'] = $info_r['ch_en'];
		$tianya_info['channel_cn'] = $info_r['ch_cn'];
		$tianya_info['title'] = $info_r['title'];
		$tianya_info['author_id'] = $info_r['aid'];
		$tianya_info['author_name'] = $info_r['aname'];
		$tianya_info['pid_list'] = $pid_list_s;
		$tianya_info['count'] = 0;
		$tianya_info['time'] = date('Y-m-d H:i:s');
		
		$info_obj->info(
			$tianya_info['name'],
			$tianya_info['type'],
			$tianya_info['channel_en'],
			$tianya_info['channel_cn'],
			$tianya_info['title'],
			$tianya_info['author_id'],
			$tianya_info['author_name'],
			$tianya_info['pid_list'],
			$tianya_info['count'],
			$tianya_info['time']
		);
		$info_id = $info_obj->Save();	
	}else{		//找到数据,更新
		$info_old_id = $info_old[0]->infoId;
		$count = $info_old[0]->count;
		
		$info_new = $info_obj->Get($info_old_id);
		//print_r($info_new);
		$info_obj->title = $info_r['title'];
		if($info_obj->author_id == 0){
			if($info_r['aid'] > 0){
				$info_obj->author_id = $info_r['aid'];
			}
		}
		$list_old_count = count(unserialize($info_obj->pid_list));
		$list_new_count = count($pid_list_r);
		if($list_new_count > $list_old_count){
			$info_obj->pid_list = $pid_list_s;
		}		
		$info_obj->time = date('Y-m-d H:i:s');
		
		$info_id = $info_obj->Save();
	}
	//echo $info_id;
	//print_r($info_r);
	if($info_id > 0){
		$out = array();
		$out['id'] = $info_id;
		$out['count'] = $count;
		return $out;
	}else{
		return false;
	}
}

if($url != ''){
	/*
	 * 示例	
	$page_obj = new get_url_cache($url);
	$page_obj->getURL();
	$content = $page_obj->getContent();
	$nav = is_tianya_cn_content($content);
	print_r($nav);
	
	$pid = get_pid_list($content, $nav[0]);
	print_r($pid);
	
	$link = mk_link_list($url, $nav, $pid);
	print_r($link);
	 */
	if(is_url($url)){	//从链接结构判断		
		$cut_url = explode('http://www.tianya.cn', $url);
		if($cut_url[0]=='' && $cut_url[1]!=''){
			$page_obj = new get_url_cache($url);
			$page_obj->getURL();
			$content = $page_obj->getContent();
			$nav = is_tianya_cn_content($content);
			//print_r($nav);
			if($nav == false){
				$is_tian_poster = 'err';
			}else{
				$pid_list_r = get_pid_list($content, $nav['type']);
				//print_r($pid_list_r);
			}
		}else{
			$is_tian = 'err';
		}
	}else{
		$right_url = 'err';
	}
	

	//构造元素
	if(isset($pid_list_r)){
		$info = array();
		//$info['name'] = base64_encode($url);
		$info['name'] = $url;
		$info['type'] = $nav['type'];
		$info['channel_en'] = $nav['ch_en'];
		$info['channel_cn'] = iconv('GBK', 'UTF-8//IGNORE',$nav['ch_cn']);
		$info['title'] = iconv('GBK', 'UTF-8//IGNORE',$nav['title']);
		$info['author_id'] = $nav['aid'];
		$info['author_name'] = iconv('GBK', 'UTF-8//IGNORE',$nav['aname']);
		$info['pid_list'] = serialize($pid_list_r);
		$info['time'] = date('Y-m-d H:i:s');
		//print_r($info);
		
		$page_id_now = $nav['pid'];		// 副版意义不大
		
		$link = mk_link_list($url, $nav, $pid_list_r);
		//print_r($link);
		$p_count = count($pid_list_r);
		$show = true;
		
		//更新页面信息
		$tianya_info_id = 0;
		$tianya_info_count = 0;
		$tianya_db = do_info($url, $nav, $pid_list_r);
		if($tianya_db){
			$tianya_info_id = $tianya_db['id'];
			$tianya_info_count = $tianya_db['count'];
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络::天涯百宝箱</title>
	<meta name="author" content="<?php 
	if(isset($info['author_name']))
		echo $info['author_name']; 
	else echo 'www.orzero.com';
	?>" />
	<meta name="keywords" content="免费阅读,热帖,只看楼主,整理阅读,楼主帖子" />
	<meta name="description" content="或零网络,提供人性化的阅读体验,或零易读,或零阅读,或零小说,或零在线,楼主帖子" />
	<link href="./css/info.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery.json-2.2.min.js"></script>
	<script type="text/javascript" src="./update.js"></script>
<script type="text/javascript">
<?php 
//定义全局变量,便于js调用:信息ID,整理到的页号;	
/*
 * 安全性考虑,取消info_id的传递;
if(isset($tianya_info_id) && $tianya_info_id > 0){
	echo "\t".'var info_id = '.$tianya_info_id.';'."\n";
}else{
	echo "\t".'var info_id = 0;';
}*/
if(isset($tianya_info_count) && $tianya_info_count > 0){
	echo 'var info_count = '.$tianya_info_count.';'."\n";
}else{
	$tianya_info_count = 0;
	echo 'var info_count = 0;'."\n";
}
?>
$(document).ready(function(){	
var log = $("#dialog");
<?php if(isset($is_tian_poster) && ($is_tian_poster=='err')){ ?>
	log.attr('title', '链接错误');
	log.html('<p>' + '当前网址不是天涯的帖子链接' + '</p>');	
	log.dialog({
		bgiframe: true,
		modal: true,
		resizable: false,
		buttons: {
			Ok: function() {
				$(this).dialog('close');
			}
		}
	});
	log.dialog('open');
<?php }
	if(isset($is_tian) && ($is_tian=='err')){ ?>
	log.attr('title', '链接错误');
	log.html('<p>' + '当前网址不是天涯的内容' + '</p>');	
	log.dialog({
		bgiframe: true,
		modal: true,
		resizable: false,
		buttons: {
			Ok: function() {
				$(this).dialog('close');
			}
		}
	});
	log.dialog('open');
<?php }
	if(isset($right_url) && ($right_url=='err')){ ?>
	log.attr('title', '不是正确的网址');
	log.html('<p>' + '请检查您输入的网址是否正确'  + '</p>');	
	log.dialog({
		bgiframe: true,
		modal: true,
		resizable: false,
		buttons: {
			Ok: function() {
				$(this).dialog('close');
			}
		}
	});
	log.dialog('open');
<?php } ?>
});
</script>
</head>
<body>

<div class="logo">
<a href="http://www.orzero.com"><img border="0" src="http://www.orzero.com/orzero.jpg" /></a>
</div>

<div style="display: none;" class="description">
<span>请在文本框输入您想要整理的贴子的完整链接,然后再点</span>
<span style="color:#ffffff;background-color:#005EAC;">[分析]</span>
<span>按钮</span>
</div>

<form id="urlform" action="" method="post">
<div class="form">
<input class="inputtext" name="url" type="text" value="<?php echo $url; ?>" size="70" maxlength="255" />
<input class="input-submit" type="submit" value="分析" />
</div>
</form>

<?php if($show){ ?>
<div class="show" style="display:none;">
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header">
				<th>频道</th>
				<th>标题</th>
				<th>作者</th>
				<th>页数</th>
				<th>功能</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $info['channel_cn']; ?></td>
				<td><?php echo $info['title']; ?></td>
				<td><?php echo $info['author_name']; ?></td>
				<td><?php echo $p_count; ?></td>
				<td id="update" class="td-submit">整理</td>
			</tr>
		</tbody>
	</table>
</div>

<div id="update_log" style="display:none;">
<div id="progressbar"></div>
</div>

<div id="link_list" style="display:none;" value="<?php echo $tianya_info_count; ?>" run="1">
<?php 
$i = 0;
foreach($link as $alink){
	echo '<ol>'
		.'<li class="fu">'.$alink['fu'].'</li>'
		.'<li class="pu">'.$alink['pu'].'</li>'
		.'<li class="fv">'.$alink['fv'].'</li>'
		.'<li class="st">'.$alink['st'].'</li>'
	.'</ol>'."\n";
}
?>
</div>
<?php } ?>

<div id="dialog" style="display:none;"></div>

</body>
</html>

