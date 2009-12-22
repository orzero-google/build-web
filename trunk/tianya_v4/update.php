<?php
/**
 * 先判断页面类型，主版还是副版
 * 接着提取导航数据
 */
include_once './GetPg.class.php';
include_once './tianya.php';

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

if($url != ''){
	/*
	 * 事例	
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
				$pid_list_r = get_pid_list($content, $nav[0]);
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
		$info['name'] = base64_encode($url);
		$info['type'] = $nav[0];
		$info['channel_en'] = $nav[1];
		$info['channel_cn'] = iconv('GBK', 'UTF-8//IGNORE',$nav[2]);
		$info['title'] = iconv('GBK', 'UTF-8//IGNORE',$nav[3]);
		$info['author_id'] = $nav[5];
		$info['author_name'] = iconv('GBK', 'UTF-8//IGNORE',$nav[6]);
		$info['pid_list'] = serialize($pid_list_r);
		$info['time'] = date('Y-m-d H:i:s');
		//print_r($info);
		
		$page_id_now = $nav[4];		// 副版意义不大
		
		$link = mk_link_list($url, $nav, $pid_list_r);
		//print_r($link);
		$p_count = count($pid_list_r);
		$show = true;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络::天涯百宝箱</title>
	<meta name="author" content="'.$p_info_utf8[6].'" />
	<meta name="keywords" content="免费阅读,热帖,只看楼主,整理阅读,楼主帖子" />
	<meta name="description" content="或零网络,提供人性化的阅读体验,或零易读,或零阅读,或零小说,或零在线,楼主帖子" />
	<link href="./css/info.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>	
	<script type="text/javascript" src="./update.js"></script>	
<script type="text/javascript">
$(document).ready(function(){	
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
<?php } ?>

<?php if(isset($is_tian) && ($is_tian=='err')){ ?>
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
<?php } ?>

<?php if(isset($right_url) && ($right_url=='err')){ ?>
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
<a href="http://www.orzero.com"><img width="200" height="30" border="0" src="http://www.orzero.com/orzero.jpg" /></a>
</div>
<div style="display: none;" class="description">
<span>请在文本框输入您想要整理的贴子的完整链接,然后再点</span>
<span style="color:#ffffff;background-color:#005EAC;">[分析]</span>
<span>按钮</span>
</div>

<form id="urlform" action="" method="post">
<div class="form">
<input class="inputtext" name="url" type="text" value="<?php echo $url; ?>" size="80" maxlength="255" />
<input class="input-submit" type="submit" value="分析" />
</div>
</form>

<div class="show">
<?php if($show){ ?>
	<table class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header">
				<th>频道</th>
				<th>标题</th>
				<th>作者</th>
				<th>页数</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $info['channel_cn']; ?></td>
				<td><?php echo $info['title']; ?></td>
				<td><?php echo $info['author_name']; ?></td>
				<td><?php echo '&nbsp;'.$p_count; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php } ?>
<div id="dialog" style="display:none;">
</div>

</body>
</html>

