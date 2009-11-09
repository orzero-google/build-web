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
	var sdata = 'content='+str;

	$.ajax({
		type: "get",
		url: get_url,
		dataType: "json",
		data: sdata,
		beforeSend: function(XMLHttpRequest){
			$('<div class="quick-alert">网页分析中,请稍后</div>')
			.insertAfter( $("#button2") )
			.fadeIn('slow')
			.animate({opacity: 1.0}, 3000)
			.fadeOut('slow', function() {
			 $(this).remove();
			});
		},	
		success: function(data, textStatus){
			$("#output_div").empty().append(show_the_analyze(data)); 
		},
		complete: function(XMLHttpRequest, textStatus){

		},
		error: function(){
			//请求出错处理
			alert('分析网址:无法从服务器取得内容');
		}
	});  		

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
	
	$("#button2").click(get_page);
	//alert('bt2');
	//取得输入框里面的网址
	//var pu = base64_encode('http://www.tianya.cn/publicforum/content/feeling/1/1025915.shtml');
	//var pu = base64_encode('http://www.tianya.cn/techforum/content/213/3072.shtml');
	//var pu = base64_encode( $('#text_content').val() );


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
	
	//});
}); 



//采集
function get_page(){
	//alert(this);
	//pu_s = this.val();
	
	var to_get_pid = $("#to_get_pid").val();	
	
	//alert(to_get_pid);
	//select_a = "#output_div > a[pid=\""+to_get_pid+"\"]";
	//select_a = "a[pid=\""+to_get_pid+"\"]";
	//alert(select_a);
	//alert ($("a[pid=\""+to_get_pid+"\"]").attr("pid"));
	//alert ($("#output_div > a[pid=\""+to_get_pid+"\"]").attr("href"));
	
	if($("#channel").val() == 1){
		if(to_get_pid - $("#output_div > a:last").attr("pid") == 1){
			//alert('整理完成');
			//alert(to_get_pid);
			//alert($("#output_div > a:last").attr("pid"));
			return true;
		}
		var pu = base64_encode($("#output_div > a[pid=\""+to_get_pid+"\"]").attr("href"));		
		//alert($("#output_div > a[pid=\""+to_get_pid+"\"]").attr("href"));
		var channel = 1;
	}else if($("#channel").val() == 2){
		if(to_get_pid > $("#pID").val()){
			//alert('整理完成');
			return true;
		}		
		alert($("#output_div > a").attr("href"));
		var pu = base64_encode($("#output_div > a").attr("href"));
		var apn = $("#apn").val();
		var intLogo = $("#intLogo").val();
		//var pID = $("#pID").val();
		var pID = to_get_pid;
		var rs_permission = $("#rs_permission").val();		
		var channel = {
			"apn" : apn,
			"intLogo" : intLogo,
			"pID" : pID,
			"rs_permission" : rs_permission
		};
		
	}else{
		alert("请先分析网页");
		return false;	
	}
	//alert("开始整理第"+to_get_pid+"页");

	var page = parseInt(to_get_pid);
	var channel_encode = base64_encode(($.toJSON(channel)));
	//var channel_encode = base64_encode(channel);
	var rget_url = 'run.get.page.php';
	var rdata = 'pn='+base64_encode(to_get_pid)+'&pu='+pu+'&channel='+channel_encode;

	//$("#output_div").slideUp(5000, function(){
		//alert("test");
	//});		

		//alert (rget_url+'?'+rdata);
		
		$.ajax({
			type: "get",
			url: rget_url,
			dataType: "html",
			timeout: 5000,
			data: rdata,
			beforeSend: function(XMLHttpRequest){
				$('<div class="quick-alert">整理第'+page+'页</div>')
				.insertAfter( $("#button2") )
				.fadeIn('slow')
				.animate({opacity: 1.0}, 3000)
				.fadeOut('slow', function() {
				 $(this).remove();
				});
				page = parseInt(to_get_pid)+parseInt(1);
			},	
			success: function(data, textStatus){
				//alert(page);
				$("#output_div2").empty().append(data); 
				$("#to_get_pid").val(page);
				get_page();
			},
			complete: function(XMLHttpRequest, textStatus){
	
			},
			error: function(){
				//请求出错处理
				alert('开始整理:无法从服务器取得内容');
			}
		}); 
	return;
}


//构造分析结果
function show_the_analyze(json_data){
	//var json_data = $.evalJSON(json_data_str);
	//var json_data = json_data_str.trim();
	//alert(json_data);
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
		msg += '<input type="hidden" id="channel" value="1" />'+"\n";
		msg += '<input type="hidden" id="to_get_pid" value="1" />'+"\n";			//需要取得的页号
		$.each(json_data[2], function(i,page_url){		//生成链接列表
			msg += '\t<td><a href="'+page_url+'" pID="'+(i+1)+'">第'+(i+1)+'页</a>&nbsp;</td>'+"\n";
		});
	}else if(channel_id == 2){
		msg += '<input type="hidden" id="channel" value="2" />'+"\n";					
		msg += '<input type="hidden" id="to_get_pid" value="1" />'+"\n";			//需要取得的页号
		msg += '<input type="hidden" id="apn" value="'+json_data[1]+'" />'+"\n";
		msg += '<input type="hidden" id="intLogo" value="0" />'+"\n";
		msg += '<input type="hidden" id="pID" value="'+page_num+'" />'+"\n";
		msg += '<input type="hidden" id="rs_permission" value="1" />'+"\n";
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
	<input id="button1" type="button" value="分析网址"><input id="button2" type="button" value="开始整理">
	</div>
	<div class="output-div-container">	
		<div id="output_div"></div>
		<div id="output_div2"></div>
	</div>
</div>

</body>
</html>
