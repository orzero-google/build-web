<?php
include_once './configuration.php';
include_once './objects/class.database.php';
include_once './objects/class.info.php';

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

//检查参数


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

$info_obj = new info();
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
    <h1>豆瓣电影标签</h1>
    <div class="grid-16-8 clearfix">
		<div class="article">
        
			<div style="height:20px; border-bottom: 1px solid rgb(204, 204, 204); padding-bottom: 5px; margin-bottom: 10px;" class="clearfix">
			    <span class="rr greyinput">
			        分类浏览 /
			        <a href="/movie/tag/?view=cloud">所有热门标签</a>
			    </span>
			</div>
	        
	        <a name="类型"><h2 style="padding-top:10px">类型 · · · · · · </h2></a>
	        <table class="tagCol">
	            <tbody>
	                        <tr>
	                    <td><a href="./爱情">爱情</a><b>(1347770)</b></td>
	                    <td><a href="./喜剧">喜剧</a><b>(1154055)</b></td>	
	                    <td><a href="./经典">经典</a><b>(778823)</b></td>
	                    <td><a href="./科幻">科幻</a><b>(652474)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./动作">动作</a><b>(606848)</b></td>
	                    <td><a href="./青春">青春</a><b>(582940)</b></td>	
	                    <td><a href="./剧情">剧情</a><b>(429777)</b></td>
	                    <td><a href="./悬疑">悬疑</a><b>(325016)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./惊悚">惊悚</a><b>(297897)</b></td>
	                    <td><a href="./恐怖">恐怖</a><b>(238967)</b></td>	
	                    <td><a href="./动画片">动画片</a><b>(236177)</b></td>
	                    <td><a href="./纪录片">纪录片</a><b>(233126)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./魔幻">魔幻</a><b>(231673)</b></td>
	                    <td><a href="./犯罪">犯罪</a><b>(215762)</b></td>	
	                    <td><a href="./动漫">动漫</a><b>(205447)</b></td>
	                    <td><a href="./情色">情色</a><b>(195948)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./励志">励志</a><b>(190479)</b></td>
	                    <td><a href="./搞笑">搞笑</a><b>(185948)</b></td>	
	                    <td><a href="./短片">短片</a><b>(142125)</b></td>
	                    <td><a href="./传记">传记</a><b>(126895)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./音乐">音乐</a><b>(123562)</b></td>
	                    <td><a href="./黑色幽默">黑色幽默</a><b>(117826)</b></td>	
	                    <td><a href="./暴力">暴力</a><b>(115410)</b></td>
	                    <td><a href="./黑帮">黑帮</a><b>(108434)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./卡通">卡通</a><b>(83645)</b></td>
	                    <td><a href="./奇幻">奇幻</a><b>(83430)</b></td>	
	                    <td><a href="./漫画改编">漫画改编</a><b>(58703)</b></td>
	                    <td><a href="./史诗">史诗</a><b>(57632)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./童话">童话</a><b>(52168)</b></td>
	                    <td><a href="./校园">校园</a><b>(51999)</b></td>	
	                    <td><a href="./伦理">伦理</a><b>(49450)</b></td>
	                    <td><a href="./cult">cult</a><b>(45028)</b></td>
	                        </tr>
	                        <tr>
	                    <td><a href="./浪漫">浪漫</a><b>(44868)</b></td>
	                    <td><a href="./血腥">血腥</a><b>(43355)</b></td>	
	                    <td><a href="./音乐剧">音乐剧</a><b>(42879)</b></td>
	                    <td><a href="./animation">animation</a><b>(42456)</b></td>
	                        </tr>
	            </tbody>
	        </table>
		</div>
	</div>
</div>

</body>
</html>