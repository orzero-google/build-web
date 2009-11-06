<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Super AJAX Programming Seed v.1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="jquery-1.3.2.js" type="text/javascript"></script>
<script src="base64encode.js" type="text/javascript"></script>
<script src="jquery.json-2.2.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){ 
	
	$("#button1").click(function(){ 
	//取得输入框里面的网址
	var str = base64_encode( $('#text_content').val() );	
	var get_url = 'script_page.php';
	var sdata = '?content='+str;

	$.ajax({
		type: "get",
		url: get_url,
		data: sdata,
		beforeSend: function(XMLHttpRequest){
			$('<div class="quick-alert">数据加载中，请稍后</div>')
			.insertAfter( $("#button1") )
			.fadeIn('slow')
			.animate({opacity: 1.0}, 3000)
			.fadeOut('slow', function() {
			 $(this).remove();
			});
		},	
		success: function(data, textStatus){
			$("#output_div").append(show_the_analyze(data)); 
		},
		complete: function(XMLHttpRequest, textStatus){
			$('<input id="button2" type="button" value="开始整理">')
			.insertAfter( $("#button1") )
			.fadeIn('slow')
			.animate({opacity: 1.0}, 3000);	
		},
		error: function(){
			//请求出错处理
			alert('无法从服务器取得内容');
		}
	});  		
	   /*
		$.getJSON(get_url+data,
		function(data){
			$("#output_div").append(show_the_analyze(data)); 
		});
		*/
	})

/*
	 $.ajax({
	   type: "post",
	   url: "script_page.php",
	   data: 'content='+str,
	   beforeSend: function(XMLHttpRequest){
			$('<div class="quick-alert">数据加载中，请稍后</div>')
				.insertAfter( $("#button1") )
				.fadeIn('slow')
				.animate({opacity: 1.0}, 3000)
				.fadeOut('slow', function() {
				  $(this).remove();
				});

	   },
	   success: function(data, textStatus){
	   	//alert(data);
	   	//var base64_page = base64_decode(data);
	   	//alert(base64_page);
			//$("#output_div").empty().append(base64_page);
			//$("#output_div").empty().append($.evalJSON(data)[0]);
			//$("#output_div").empty().append(data);
			//alert(data);
			var out_json = $.evalJSON(data);
			alert(out_json);
			//$("#output_div").empty().append(out_json);
			//$("#output_div").append('<tr>');
			$.each(out_json, function(i,n){
				//alert( "整理第: " + i + "页\n页号  : " + n );				
				//$("#output_div").empty().append( "Item #" + i + ": " + n ).toggle(3000); 
				$("#output_div").append('<td><a href="'+n+'">第'+i+'页</a></td>'); 
			});
			//$("#output_div").append('</tr>');

	   },
	   complete: function(XMLHttpRequest, textStatus){
			 //alert(str);

			$('<div class="quick-alert">成功取得首页</div>')
				.insertAfter( $("#button1") )
				.fadeIn('slow')
				.animate({opacity: 1.0}, 3000)
				.fadeOut('slow', function() {
				  $(this).remove();
				});
	
	   },
	   error: function(){
			//请求出错处理
			alert('error');
	   }
	 }); 
 */	
	
	$("#button2").click(function(){ 
	//取得输入框里面的网址
	//var pu = base64_encode('http://www.tianya.cn/publicforum/content/feeling/1/1025915.shtml');
	//var pu = base64_encode('http://www.tianya.cn/techforum/content/213/3072.shtml');
	var pu = base64_encode( $('#text_content').val() );

	/*
	var channel = {
	"form":{
	"apn" : '101260,110324,124881',
	"intLogo" : '0',
	"pID" : '3',
	"rs_permission" : '1'}
	}
	var channel = new Array();
	channel = {
	"apn" : '101260,110324,124881',
	"intLogo" : '0',
	"pID" : '1',
	"rs_permission" : '1'
	};
	//channel = 1;
	*/


	var channel_encode = base64_encode(($.toJSON(channel)));
	//var channel_encode = base64_encode(channel);
	var get_url = 'run.get.page.php';
	var data = '?pu='+pu+'&channel='+channel_encode;

	$.get(get_url+data,
			function(data2){
			//alert(data);
			//alert($.evalJSON(data));
				$("#output_div").append(data2); 
			});	
	})
});

//构造分析结果
function show_the_analyze(json_data){

	if(json_data == 'is_not_tianya_content'){
		return '<p>地址不正确, 或者不是天涯的帖子, 请检查</p>';
	}

	var channel_id = json_data[0][0];		//1 or 2
	var forum_id = json_data[0][1];			//论坛id
	var forum_name = json_data[0][2];		//论坛名字
	var title = json_data[0][3];			//帖子标题
	var tid = json_data[0][4];				//贴号

	var page_num = '';
	var page_at = '';
	$.each(json_data[1], function(num,page_id){
		if(page_id == tid){
			page_at = num+1;
		}
		page_num = num+1;
	});
	
	var msg = '<pre>'+"\n";
	msg += '版块名称:'+forum_name+"\n";
	msg += '帖子标题:'+title+"\n";
	msg += '页数:'+page_num+"\n";
	if(channel_id == 1){
		msg += '当前页数:'+page_at+"\n";
	}
	msg += '</pre>'+"\n";
	msg += '<tr>'+"\n";
	if(channel_id == 1){
		$.each(json_data[2], function(i,page_url){		//生成链接列表
			msg += '\t<td><a href="'+page_url+'" pID="'+(i+1)+'">第'+(i+1)+'页</a>&nbsp;</td>'+"\n";
		});
	}else if(channel_id == 2){
		msg += '\t<td><a href="'+json_data[2]+'" apn="'+json_data[1]+'" intLogo="0" pID="'+page_num+'" rs_permission="1">目标页(属于副版,实际只有一个地址)</a>&nbsp;</td>'+"\n";
	}
	msg += '</tr>'+"\n";
	return msg;	
}
</script>
<link href="styles.css" rel="stylesheet" type="text/css"></link>	
</head>

<body>
<div class="ajax-div">
	<div class="input-div">
	请输入你帖子地址:
	<input type="text" id="text_content" value="http://www.tianya.cn/techforum/content/213/3072.shtml" size="80">
	<input id="button1" type="button" value="分析网址">
	</div>
	<div class="output-div-container">	
		<div id="output_div"></div>
	</div>
</div>

</body>
</html>
