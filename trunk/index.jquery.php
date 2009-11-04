<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Super AJAX Programming Seed v.1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="jquery-1.3.2.js" type="text/javascript"></script>
<script src="base64encode.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){ 
$("#button1").click(function(){ 
var str = base64_encode( $('#text_content').val() );
//alert( str );
	 $.ajax({
	   type: "post",
	   url: "script_page.php",
	   data: $('#text_content').val(),
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
			$(".ajax.ajaxResult").html("");
			$("item",data).each(function(i, domEle){
				$(".ajax.ajaxResult").append("<li>"+$(domEle).children("title").text()+"</li>");
			});
	   },
	   complete: function(XMLHttpRequest, textStatus){
			//HideLoading();
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
	<input type="text" id="text_content" size="40">
	<input id="button1" type="button" value="提交表单">
	</div>
	<div class="output-div-container">	
		<div id="output_div"></div>
	</div>
</div>

</body>
</html>
