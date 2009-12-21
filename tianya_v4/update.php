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

if($url != ''){
	/*
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
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>或零网络::天涯百宝箱</title>
	<meta name="author" content="'.$p_info_utf8[6].'" />
	<meta name="keywords" content="只看楼主,整理阅读" />
	<meta name="description" content="或零易读,或零阅读,或零小说,或零在线,显示楼主帖子" />
	<link href="./css/info.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>	
<script type="text/javascript">
	

$(document).ready(function(){	
	var o = $("input.inputtext");
	var ds_text = $("div.description").text();
	
	o.css('color', '#aaaaaa').attr('value', ds_text).attr('st', 0);
	
	o.focus(function(){
		$(this).attr('value', '');
		$(this).css('color', '#333333');
		$(this).attr('st', 1);
	});


	
});

$(function () {
	var o = $("input.inputtext");
	var form = $("#urlform");	
	var ds_html = $("div.description").html();
	var log = $("#dialog");
	log.attr('title', '错误');
	log.append('<p>' + ds_html + '</p>');	
	
	form.submit(function(){
		if(o.attr('st') == 0){			
			log.dialog({
				bgiframe: true,
				modal: true,
				buttons: {
					Ok: function() {
						$(this).dialog('close');
					}
				}
			});
			return false;
		}
	});
});
</script>
</head>
<body>
<div class="logo">
<a href="http://www.orzero.com"><img width="200" height="30" border="0" src="http://www.orzero.com/orzero.jpg" /></a>
</div>
<div style="display: none;" class="description">
<span>请在文本框输入您想要整理的贴子链接,然后再点</span>
<span style="color:#ffffff;background-color:#005EAC;">[分析]</span>
<span>按钮</span>
</div>

<form id="urlform" action="" method="post">
<div class="form">
<input class="inputtext" name="url" type="text" value="<?php echo $url; ?>" size="80" maxlength="255" />
<input class="input-submit" type="submit" value="分析" />
</div>
</form>

<div id="dialog" style="display:none;">
</div>

</body>
</html>

