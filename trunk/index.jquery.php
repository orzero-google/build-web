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
			var out_json = $.evalJSON(data);
			//$("#output_div").empty().append(out_json);

			$.each(out_json, function(i,n){
				//alert( "整理第: " + i + "页\n页号  : " + n );				
				//$("#output_div").empty().append( "Item #" + i + ": " + n ).toggle(3000); 
				$("#output_div").append('<p>'+i+' : '+n+'</p>'); 
			});

	   },
	   complete: function(XMLHttpRequest, textStatus){
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
	   }
	 });	

});
})



</script>
<link href="styles.css" rel="stylesheet" type="text/css"></link>	
</head>

<body>
<div class="ajax-div">
	<div class="input-div">
	请输入你帖子地址:
	<input type="text" id="text_content" value="http://www.tianya.cn/techforum/content/213/3072.shtml" size="40">
	<input id="button1" type="button" value="提交表单">
	</div>
	<div class="output-div-container">	
		<div id="output_div"></div>
	</div>
</div>

</body>
</html>
