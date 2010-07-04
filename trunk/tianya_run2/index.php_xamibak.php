<?php
/**
 * 先判断页面类型，主版还是副版
 * 接着提取导航数据
 */
include_once 'configuration.php';
include_once $set['root'].'/class/GetPg.class.php';
include_once $set['root'].'/function/tianya.php';
include_once $set['root'].'/objects/class.info.php';

$show = false;		//成功取得内容后置为真
$url = '';
//取得参数
define('IS_GPC', get_magic_quotes_gpc());
foreach(array('_GET','_POST') as $_request) {
	foreach($$_request as $_key => $_value) {
		if ($_key{0} != '_') {
			if (IS_GPC) {
				//$_value = s_array($_value);
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
	<link rel="stylesheet" type="text/css" href="css/orzero.css" />
	<link href="css/info.css" rel="stylesheet" type="text/css" />
	<link href="css/index.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="css/start/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
	<script src="http://www.google.com/jsapi"></script>
	<script>
  	google.load("jquery", "1.3.2");
  	google.load("jqueryui", "1.7.2");
	</script>
	<script type="text/javascript" src="js/update.min.js"></script>
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

<style type="text/css">
.gb1, .gb3{height: 22px;margin-right: 0.43em;vertical-align: top;font-size:13px;}
a.gb1, a.gb2, a.gb3{color: #0000cc;}
a{text-decoration:none;}
a:hover{color: #ffffff;background-color: #3080cb;background-image: none;background-repeat: repeat;background-attachment: scroll;background-position: 0% 0%;}
</style>
<div id="gbar">
	<nobr>
	
		<a href="http://read.orzero.com" onclick="gbar.qs(this);" class="gb1"><b>或零阅读</b></a>
		<a href="http://www.orzero.net/html2pdf" onclick="gbar.qs(this);" class="gb1">或零工具</a>
		<a href="http://www.orzero.com/online" onclick="gbar.qs(this);" class="gb1">或零在线</a>
		<a href="http://read.orzero.com/list.php?channel=all" onclick="gbar.qs(this);" class="gb1">或零读书</a>
		<a href="http://www.orzero.com/tools/index.htm" onclick="gbar.qs(this);" class="gb1">在线工具网址</a>
		<a href="http://www.google.com/search?hl=en&newwindow=1&q=site:orzero.com" onclick="gbar.qs(this);" class="gb1">社区</a>
		<a href="http://read.orzero.com/list.php?channel=index" onclick="gbar.qs(this);" class="gb1">官方网</a>
		<a href="http://www.orzero.com" onclick="gbar.qs(this);" class="gb1">博客</a>                    
		<a href="http://blog.orzero.com" onclick="gbar.qs(this);" class="gb1">音乐</a>
		<a href="http://www.orzero.com" onclick="this.blur();gbar.tg(event);return !1" aria-haspopup="true" class="gb3">
			<u style="height:22px;vertical-align:top;">杂文</u><small style="text-decoration:none;">▼</small>
		</a>
		
		<div id="gbi">
			<a href="http://orzero.com/2.htm" onclick="gbar.qs(this);" class="gb2">推荐杂文</a>
			<a href="http://orzero.com/modem.htm" onclick="gbar.qs(this);" class="gb2">现代小说</a>
			<a href="http://orzero.com/history/index.htm" onclick="gbar.qs(this);" class="gb2">时代聚焦</a>
			<a href="http://orzero.com/classic.htm" onclick="gbar.qs(this);" class="gb2">古典文学</a>
			<a href="http://orzero.com/science.htm" onclick="gbar.qs(this);" class="gb2">科幻小说</a>
			<a href="http://orzero.com/shanwen.htm" onclick="gbar.qs(this);" class="gb2">散文戏剧</a>
			<div class="gb2"><div class="gbd"></div></div>
			
			<a href="http://orzero.com/foreign.htm" class="gb2">外国文学</a>
			<a href="http://orzero.com/netbook/net.htm" onclick="gbar.qs(this);" class="gb2">网络精粹</a>
			<a href="http://orzero.com/zhentan/zhentan.htm" class="gb2">侦探推理</a>
			<a href="http://orzero.com/Wuxia.htm" class="gb2">武侠小说</a>
			<div class=gb2><div class=gbd></div></div>
			
			<a href="http://www.orzero.com" onclick="gbar.qs(this);" class="gb2">游戏</a>
			<a href="http://www.orzero.com" onclick="gbar.qs(this);" class="gb2">下载</a>
			<a href="http://www.orzero.com/eng.htm" onclick="gbar.qs(this);" class="gb2">学习</a>
			<div class="gb2"><div class="gbd"></div></div>
			
			<a href="http://www.orzero.com" class="gb2">手机网址</a>
		</div>
		
	</nobr>	
</div>
<div class="gbh" style=left:0></div>

	  
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7387085-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<script>
    window.gbar = {}; (function() {
        var b = window.gbar,
        f, h;
        b.qs = function(a) {
            var c = window.encodeURIComponent && (document.forms[0].q || "").value;
            if (c) a.href = a.href.replace(/([?&])q=[^&]*|$/,
            function(i, g) {
                return (g || "&") + "q=" + encodeURIComponent(c)
            })
        };
        function j(a, c) {
            a.visibility = h ? "hidden": "visible";
            a.left = c + "px"
        }
        b.tg = function(a) {
            a = a || window.event;
            var c = 0,
            i, g = window.navExtra,
            d = document.getElementById("gbi"),
            e = a.target || a.srcElement;
            a.cancelBubble = true;
            if (!f) {
                f = document.createElement(Array.every || window.createPopup ? "iframe": "div");
                f.frameBorder = "0";
                f.src = "#";
                d.parentNode.appendChild(f).id = "gbs";
                if (g) for (i in g) d.insertBefore(g[i], d.firstChild).className = "gb2";
                document.onclick = b.close
            }
            if (e.className != "gb3") e = e.parentNode;
            do c += e.offsetLeft;
            while (e = e.offsetParent);
            j(d.style, c);
            f.style.width = d.offsetWidth + "px";
            f.style.height = d.offsetHeight + "px";
            j(f.style, c);
            h = !h
        };
        b.close = function(a) {
            h && b.tg(a)
        }
    })();
</script>


<div class="logo">
<a href="http://www.orzero.com"><img border="0" src="orzero.jpg" /></a>
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

<div id="link_list" style="display:none;" value="<?php echo $tianya_info_count; ?>" run="1" status="start">
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

<iframe id="nav" src="list.php?channel=index" frameborder="0" style="margin-top:70px;width:632px;height:460px;"></iframe>

<div class="visualClear"></div>
<div id="footer" style="margin-top:420px;position:relative;">
		<div id="f-poweredbyico"><a title="orzero" href="http://www.orzero.com"><img title="或零,0" src="huoling.gif" height="92" width="96" alt="Powered by ORZERO" /></a></div>
		<div id="f-copyrightico"><a title="或零" href="http://www.orzero.com"><img title="或零, 为网友提供简易有价值的服务, 请推荐给您的朋友, http://www.orzero.com" src="orzero.jpg" width="240" height="50" alt="Wikimedia Foundation"/></a></div>
	<ul id="f-list">
		<li>欢迎访问<a title="或零" href="http://www.orzero.com/">或零</a>, 
		<a title="或零网络" href="http://www.orzero.net/" target="_blank">或零网络</a>宗旨: 为广大网友提供简易有价值的服务.</li>
		<li id="server"><a title="或零家园" href="http://home.orzero.com/" target="_blank">或零交友</a></li>
		<li id="shop"><a href="http://shop.orzero.com/" target="_blank">或零商店</a></li>
		<li><a class="internal" href="http://read.orzero.com" title="或零阅读" target="_blank">或零阅读</a></li>
		<li>与站长取得联系:可以到<a title="或零博客" href="http://www.orzero.net" target="_blank">或零博客</a>留言</li><br />
		
		<li>陆续完善的服务:
		<a title="html2pdf" href="http://www.orzero.net/html2pdf" target="_blank">html转pdf</a>, 
		<a title="html2pdf" href="http://read.orzero.com/list.php?channel=all" target="_blank">天涯自动整理</a>,
		<a title="或零在线, orzero online" href="http://www.orzero.com/online/" target="_blank">或零在线</a>,
		<a title="或零整理, web tools" href="http://www.orzero.com/tools/" target="_blank">或零整理</a>,
		<a title="或零新闻, orzero news" href="http://news.orzero.com/" target="_blank">或零新闻</a>,
		<a title="或零音乐, orzero music" href="http://music.orzero.com/" target="_blank">或零音乐</a>,
		<a title="或零信息, orzero info" href="http://info.orzero.com/" target="_blank">或零信息</a>
		欢迎大家到<a title="或零家园" href="http://home.orzero.com">或零家园</a>提出自己的意见和建议,或零将不断完善和改进</li><br />
		
		<li>友情链接: 
		<a title="搜搜, orzero soso" href="http://www.soso.com/q?w=site:orzero.com" target="_blank">SOSO搜搜或零</a>
		<a title="yahoo中国, orzero yahoo" href="http://www.yahoo.cn/s?p=site:orzero.com" target="_blank">yahoo中国或零</a>
		<a title="sn,log,snlog,info" href="http://www.snlg.info" target="_blank">snlg</a>
		<a title="搜狗, orzero sogou" href="http://www.sogou.com/web?query=site%3Aorzero.com" target="_blank">搜狗搜索或零</a>
		<a title="有道搜索, orzero youdao" href="http://www.youdao.com/search?q=site:orzero.com" target="_blank">有道搜索或零</a>
		<a title="avup, info, hot, girl, img, jpeg, av, jp, hot, s, e, x" href="http://avup.info" target="_blank">avup</a>
		<a title="sogou搜索, orzero sogou" href="http://www.sogou.com/web?query=site:orzero.com" target="_blank">sogou搜索或零</a>
		<a title="google search, orzero google" href="http://www.google.com/search?q=site%3Aorzero.com" target="_blank">google search或零</a>
		<a title="ff,file,upload,ffup,file upload,info" href="http://www.snlg.info" target="_blank">ffup</a>
		<a title="谷歌搜索, orzero google.cn" href="http://www.google.com/search?q=site%3Aorzero.com" target="_blank">谷歌搜索或零</a>
		<a title="新新人博客, xxer" href="http://www.xxer.info" target="_blank">新新人博客</a>
		<a title="baidu百度, orzero baidu" href="http://www.baidu.com/s?wd=site%3Aorzero.com" target="_blank">百度搜索或零</a>				
		</li><br />
		
		<li id="eng"><a href="http://www.orzero.com/eng.htm" title="网址导航">站内导航</a></li>
		<li id="about"><a href="http://m.orzero.net/blog/" title="关于">或零存档</a></li>
		<li id="sitemap"><a href="http://www.orzero.com/sitemap/sitemap.php?do=showsitemap&sm=20090822.xml.gz" title="orzero.com.sitemap">网站地图</a></li>				
	</ul>
</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-12384675-1");
pageTracker._setLocalRemoteServerMode();
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>

