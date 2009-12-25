;
/**
 * @author Alexandre Magno
 * @desc Center a element with jQuery
 * @version 1.0
 * @example
 * $("element").center({
 *
 * 		vertical: true,
 *      horizontal: true
 *
 * });
 * @obs With no arguments, the default is above
 * @license free
 * @param bool vertical, bool horizontal
 * @contribution Paulo Radichi
 * @web http://www.alexandremagno.net/jquery/plugins/center/
 */
jQuery.fn.center = function(params) {

		var options = {

			vertical: true,
			horizontal: true

		}
		op = jQuery.extend(options, params);

   this.each(function(){

		//initializing variables
		var $self = jQuery(this);
		//get the dimensions using dimensions plugin
		var width = $self.width();
		var height = $self.height();
		//get the paddings
		var paddingTop = parseInt($self.css("padding-top"));
		var paddingBottom = parseInt($self.css("padding-bottom"));
		//get the borders
		var borderTop = parseInt($self.css("border-top-width"));
		var borderBottom = parseInt($self.css("border-bottom-width"));
		//get the media of padding and borders
		var mediaBorder = (borderTop+borderBottom)/2;
		var mediaPadding = (paddingTop+paddingBottom)/2;
		//get the type of positioning
		var positionType = $self.parent().css("position");
		// get the half minus of width and height
		var halfWidth = (width/2)*(-1);
		var halfHeight = ((height/2)*(-1))-mediaPadding-mediaBorder;
		// initializing the css properties
		var cssProp = {
			position: 'absolute'
		};

		if(op.vertical) {
			cssProp.height = height;
			cssProp.top = '50%';
			cssProp.marginTop = halfHeight;
		}
		if(op.horizontal) {
			//cssProp.width = width;
			cssProp.left = '50%';
			cssProp.marginLeft = halfWidth;
		}
		//check the current position
		if(positionType == 'static') {
			$self.parent().css("position","relative");
		}
		//aplying the css
		$self.css(cssProp);


   });

};

$(function () {
    var bro=$.browser;	//浏览器版本
    var binfo="";
    if(bro.msie) {binfo="IE"}
    if(bro.mozilla) {binfo="FF"}
    if(bro.safari) {binfo="SF"}
    if(bro.opera) {binfo="OP"}
    
	var o = $("input.inputtext");
	var form = $("#urlform");	
	var ds_text = $("div.description").text();
	var ds_html = $("div.description").html();
	var log = $("#dialog");

	if(o.attr('value') == ''){
		o.attr('value', ds_text);
		o.css('color', '#aaaaaa').attr('st', 0).focus(function(){
			$(this).attr('value', '');
			$(this).css('color', '#333333');
			$(this).attr('st', 1);
		});
	}
	
	form.submit(function(){
		if(o.attr('st') == 0){
			log.attr('title', '错误');
			log.html('<p>' + ds_html + '</p>');	
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
			return false;
		}
	});
	
	$("div.show").show();
	$("table.ui-widget").center({
		vertical: false,
		horizontal: true
	});
	
	
	
	$("#progressbar").progressbar();
	$("input.input-submit").attr({'disabled':false});
	
	var $update_log = $("#update_log");
	if(binfo != "FF") run_st = 'clip';
	else run_st = '';
	
	$update_log.attr('title', '整理');
	$update_log.dialog({
		bgiframe: true,
		modal: true,
		//resizable: false,
		show: run_st,
		autoOpen: false,
		buttons: {
			'Start': function() {
				start();
			}
		}
	});	

	function start(){
		var run = $("#link_list").attr('run');
		alert(log.html())
		if(run == 1){
			run_start();
		}
		$("input.input-submit").attr({'disabled':true,'value':'整理中'}).css({'background-color':'#00CED1'});
		$("#update_log").dialog('option', 'buttons', {'Stop':function(){
			stop();
		}});
		
		$("#link_list").attr('value', 0).attr('run', 1);
		$("#progressbar").progressbar('option', 'value', 0);		
	}
	
	function stop(){
		$("input.input-submit").attr({'disabled':false,'value':'分析'}).css({'background-color':'#005EAC'});
		$("#update_log").dialog('option', 'buttons', {'Start':function(){
			start();
		}});
		
		$("#link_list").attr('value', 0).attr('run', 0);
		$("#progressbar").progressbar('option', 'value', 0);		
	}
	
	$("td.td-submit").css("cursor", "pointer").click(function (){
		$update_log.dialog('open');
	});
	
	
	function run_start(){
		var $link = $("#link_list ol");
		var count_link = $link.size();
		var the_link = Number($("#link_list").attr('value'));
		var page = (the_link+1);
		var run = $("#link_list").attr('run');
		var $link_info = $link.eq(the_link);
		var sdata = 'fu=' + $link_info.children("li.fu").text() +
					'&pu=' + $link_info.children("li.pu").text() +
					'&fv=' + $link_info.children("li.fv").text() +
					'&st=' + $link_info.children("li.st").text() +
					'&page=' + page;
		//进度条
		var progressVal = (the_link/count_link)*100;
		$("#progressbar").progressbar('option', 'value', progressVal);
		
		//改变标题和分析按钮
		if(the_link < count_link)
		$("#update_log").dialog('option', 'title', '整理::到'+ page +'页/总'+count_link+'页');
				
		$.ajax({
			type: "get",
			url: 'doup.php',
			dataType: "html",
			cache: false,
			timeout: 5000,
			data: sdata,
			beforeSend: function(XMLHttpRequest){
				
			},	
			success: function(data, textStatus){
				$("#link_list").attr('value', page);	//成功,计数器+1
				if(the_link < count_link && run == 1){
					run_start();
				}
				if(the_link == count_link){
					stop();
				}
			},
			complete: function(XMLHttpRequest, textStatus){

			},
			error: function(){
				//请求出错处理
				alert('开始整理:无法从服务器取得内容');
			}
		}); 
			
		
		//测试
		//alert(sdata);
		//alert($link.eq(the_link).children("li.fu").html());			
		//alert($("#link_list").attr('value'));
	}
	
});