;
$(function () {
	$("#wrap").hide();
	$("#tools_panel").hide();
	$("#page_info").hide();
});
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
			cssProp.width = width;
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

//$(function () {
$(document).ready(function(){
    var url = "";
    var $window = $(window);
    var $wrap = $("#wrap");
    var $list = $("#list");
    var $tools_panel = $("#tools_panel");
    var maxWidth = 800;
    var body_width = document.body.offsetWidth;
    var author_md5 = $("#first_author").attr('name');
    
    var bro=$.browser;	//浏览器版本
    var binfo="";
    if(bro.msie) {binfo="IE"}
    if(bro.mozilla) {binfo="FF"}
    if(bro.safari) {binfo="SF"}
    if(bro.opera) {binfo="OP"}
    
    //晃动时候闭合列表,执行关闭打开用户列表,以便勾号归位
	function rep_r(){
		var $list = $("#list");		
		if(binfo == 'FF'){
			$list.hide();
			$list.show('fast');
		}
	}	
    //作者标题栏浮动
	function show_list(){
		var log = $("#list");
		log.attr('title', '作者列表');
		//log.html('<p>' + '整理进程遇到错误,可能服务器繁忙,请稍后再试'  + '</p>');	
		log.dialog({
			bgiframe: true,
			modal: false,
			resizable: true,
			autoOpen: false,
			minWidth: 600,
			width: 600,
			//minHeight: 400,
			drag: function() {rep_r();},
			dragStart: function() {rep_r();},
			dragStop: function() {rep_r();},
			resizeStop: function() {rep_r();},
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				}
			}
		});
		rep_r();
		log.dialog('open');
	}
	
	var backtocontent = '<span style="float:right;" class="open ui-icon ui-icon-gear"></span>'
						+ '<span style="float:right;" class="show_list ui-icon ui-icon-newwin"></span>';
	if(binfo=="IE")
		backtocontent += '<div style="display:block;position:relative;top:0;right:2px;height:20px;">&nbsp;</div>';
	else{
		backtocontent += '<div style="display:inline;position:relative;top:0;right:2px;height:20px;">&nbsp;</div>';
	}
	$("div.blog").append(backtocontent);
	    
	$(".show_list").css({"text-decoration":"underline","color":"green"}).css("cursor", "pointer").click(function (){
		show_list();
	});
	
	
    //打开作者标题栏
   	$("#list li").each(function () {}).css("cursor", "pointer").click(function (){
   		var name = $(this).attr('name');
    	$("div.section h4").each(function () {
    		var the_name = $(this).attr('name');    
    		if(the_name == name){
    			$(this).show("normal");
    		}
    	});  
    	if(binfo == 'FF'){
    		$("#lists").hide('fast');
    	}
    	$("#list li").each(function () {
    		var the_name = $(this).attr('name');
    		if(the_name == name){
    			$(this).hide();
    		}    		
    	});    	
    	if(binfo == 'FF'){
    		$("#lists").show('fast');
    	}
   	});   
	
	//勾号
   	$("#list li").each(function () {
   		if(binfo == 'FF'){
   			$(this).append('<span style="position:absolute;right:0;" class="ui-icon ui-icon-check"></span>');
   		}else if(binfo == 'IE'){
   			$(this).append('<span style="position:absolute;" class="ui-icon ui-icon-check"></span>');
   		}
   	});

   	/*
   	//内容返回列表快捷键
    var backtocontent = '<span style="float:right;position:relative;" class="open ui-icon ui-icon-gear"></span><p class="backToTop">';
    backtocontent += '<a href="' + url + '#lists" scrollto="lists">↑返回用户列表</a>';
    backtocontent += '</p>';
    $("div.blog").append(backtocontent);
    */
	
	//当前作者标题开关快捷键
    $("div.blog span.open").each(function () {}).css("cursor", "pointer").click(function (){
    	var name = $(this).parent().attr("name"); 
    	$("div.section h4").each(function () {
    		var the_name = $(this).attr("name");
    		var st = $(this).css("display");    		
    		if(the_name == name){
    			if(st == 'block'){
	    			$(this).hide();
    			}else if(st == 'none'){
	    			$(this).show("fast");
    			}
    		}
    	}); 
    	
    	if(binfo == 'FF'){
    		$("#lists").hide();
    	}
       	$("#list li").each(function () {
       		var the_name = $(this).attr('name');
       		var st = $(this).css("display");  
       		if(the_name == name){
    			if(st == 'inline'){
	    			$(this).hide();
    			}else{
    				$(this).hide();
    				$(this).css('display', 'inline');    				
	    			$(this).show("fast");
    			}
       		}
       	});  
    	if(binfo == 'FF'){
    		$("#lists").show('fast');
    	}
    });

    //显示楼主帖子标题栏目,并高亮
    //alert(author_md5);
	$("div.section h4").each(function () {
		var the_name = $(this).attr("name");
		var i = 0;
		if(the_name == author_md5){
			$(this).removeClass();
			$(this).addClass('ui-accordion-header ui-helper-reset ui-state-active ui-corner-top');			
			$(this).show("fast");
			i++;
		}
    	$("#list li").each(function () {
    		var the_name = $(this).attr('name');
    		if(the_name == author_md5){
    			$(this).css('background-color','#90ee90');
    			$(this).hide();
    		}    		
    	});
	}); 

	//关闭当前作者所有标题
    $("div.section div.close").each(function () {
    	$(this).css({ "z-index":10, "width":"20px", "display":"block", "position":"relative", "float":"right"});
    	$(this).append('<span class="ui-icon ui-icon-circle-close"></span>');
    }).each(function () {}).css("cursor", "pointer").click(function () {
    	//var st = $(this).children("span");
    	var name = $(this).parent("h4").attr("name");   	
		$("div.section h4").each(function () {
			var the_name = $(this).attr("name");
			if(the_name == name){
				$(this).hide();
			}
		});	
		if(binfo == 'FF'){
			$("#lists").hide('fast');
		}
		$("#list li").each(function () {
			var the_name = $(this).attr("name");
			if(the_name == name){
				$(this).hide();
				$(this).css('display', 'inline');
				$(this).show();
			}
		});	
		if(binfo == 'FF'){
			$("#lists").show('fast');
		}
    });
	//显示当前作者所有内容
    $("div.section div.tools").each(function () {
    	$(this).css({ "z-index":10, "width":"20px", "display":"block", "position":"relative", "float":"right"});
    	$(this).append('<span class="ui-icon ui-icon-circle-plus"></span>');
    }).each(function () {}).css("cursor", "pointer").click(function () {
    	var st = $(this).children("span");
    	var name = $(this).parent("h4").attr("name");   	
    	
    	if(st.attr('class') == 'ui-icon ui-icon-circle-plus'){
    		$("div.section div.tools").each(function () {
    			var the_name = $(this).parent("h4").attr("name");
    			var the_st = $(this).children("span");
    			if(the_name == name){
    				the_st.removeClass();
    				the_st.addClass('ui-icon ui-icon-circle-minus');
    				$(this).parent("h4").next("div.blog").show();
    			}
	    		if(name == author_md5){
	    			$("td.lz").html('<span style="float:left;" class="ui-icon ui-icon-lightbulb"></span>隐藏楼主帖子');
	    		}
    		});		
    	}else if(st.attr('class') == 'ui-icon ui-icon-circle-minus'){
    		$("div.section div.tools").each(function () {
    			var the_name = $(this).parent("h4").attr("name");
    			var the_st = $(this).children("span");
    			if(the_name == name){
    				the_st.removeClass();
    				the_st.addClass('ui-icon ui-icon-circle-plus');
    				$(this).parent("h4").next("div.blog").hide();
    			}
	    		if(name == author_md5){
	    			$("td.lz").html('<span style="float:left;" class="ui-icon ui-icon-lightbulb"></span>显示楼主帖子');
	    		}
    		});		
    	}
    });


	//显示当前标题内容
    /*
    $("h3").css({"cursor":"pointer"}).click(function () {
    	$("#lists").slideToggle('normal');
    })；*/
    $("h4 > span.fopen").css({"cursor":"pointer", "margin-left":"8px"}).click(function () {
    	//$(this).parent().next("div.blog").slideToggle('normal');
    	var st = $(this).parent().children("div.tools").children("span");
    	var icon = $(this).parent().children("span.fshow");
    	//alert(st.attr('class'))    	
    	if(st.attr('class') == 'ui-icon ui-icon-circle-minus'){
    		$(this).parent().next("div.blog").fadeOut('fast');
    		st.removeClass();    		
    		st.addClass('ui-icon ui-icon-circle-plus');
    		icon.removeClass();
    		icon.addClass('fopen fshow ui-icon ui-icon-folder-collapsed');    		
    	}else if(st.attr('class') == 'ui-icon ui-icon-circle-plus'){
    		$(this).parent().next("div.blog").slideDown('normal');
    		st.removeClass();
    		st.addClass('ui-icon ui-icon-circle-minus');
    		icon.removeClass();
    		icon.addClass('fopen fshow ui-icon ui-icon-folder-open');
    	}

    });   

    
    //显示楼主功能
    $("td.lz").css({"text-decoration":"underline","color":"red"}).css("cursor", "pointer").click(function () {
    	var c = $(this).text();
    	if(binfo == 'FF'){
    		$("#lists").hide();
    	}
    	if(c == '显示楼主帖子'){
	    	$("div.blog").each(function () {
	    		var name=$(this).attr('name');
	    		var i = 0;
	    		if(name == author_md5){
	    			$(this).show('fast');
	    			i++;
	    		}
	    		if(i == 0){
	    			//alert('当前页楼主没有发帖');
	    		}
	    	});
	    	$("div.section div.tools").each(function () {
	    		st = $(this).children("span");
	    		var name = $(this).parent().attr('name');
	    		if(name == author_md5){
		    		st.removeClass();
		    		st.addClass('ui-icon ui-icon-circle-minus');
	    		}
	    	});	    	
	    	$(this).html('<span style="float:left;" class="ui-icon ui-icon-lightbulb"></span>隐藏楼主帖子');
    	}else if(c == '隐藏楼主帖子'){
	    	$("div.blog").each(function () {
	    		var name=$(this).attr('name');
	    		var i = 0;
	    		if(name == author_md5){
	    			$(this).hide();
	    			i++;
	    		}
	    		if(i == 0){
	    			//alert('当前页楼主没有发帖');
	    		}
	    	});
	    	$("div.section div.tools").each(function () {
	    		st = $(this).children("span");
	    		var name = $(this).parent().attr('name');
	    		if(name == author_md5){
		    		st.removeClass();
		    		st.addClass('ui-icon ui-icon-circle-plus');
	    		}
	    	});	 
	    	$(this).html('<span style="float:left;" class="ui-icon ui-icon-lightbulb"></span>显示楼主帖子');
    	}
    	if(binfo == 'FF'){
    		$("#lists").show('fast');
    	}
    });
    //打开全部作者
    $("td.allzz").css({"text-decoration":"underline","color":"blue"}).css("cursor", "pointer").click(function () {
    	var c = $(this).text();
    	if(binfo == 'FF'){
    		$("#lists").hide();
    	}
    	if(c == '打开全部作者'){
	    	$("div.section h4").each(function () {
	    		$(this).show('fast');
	    	});
	    	$("#list li").each(function () {
	    		$(this).hide();
	    	});	    
	    	$("#lists").hide();
	    	$(this).html('<span style="float:left;" class="open ui-icon ui-icon-gear"></span>关闭全部作者');
    	}else if(c == '关闭全部作者'){
	    	$("div.section h4").each(function () {
	    		$(this).hide();
	    	});
	    	$("#list li").each(function () {
	    		$(this).css('display', 'inline');
	    		$(this).show('fast');
	    	});	
	    	$("#lists").show('fast');
	    	$(this).html('<span style="float:left;" class="open ui-icon ui-icon-gear"></span>打开全部作者');
	    	if(binfo == 'FF'){
	    		$("#lists").show('fast');
	    	}
    	}
    });   
    //工具栏折叠
    $("th.qj").css("cursor", "pointer").click(function () {
    	//$(this).nextAll("tr").hide(); 
    	$("td.qj").slideToggle('normal');
    });
    $("th.dh").css("cursor", "pointer").click(function () {
    	//$(this).nextAll("tr").hide(); 
    	$("td.dh").slideToggle('normal');
    });   
    
    //导航
    //作者标题栏浮动
	function show_nav_log($count, $pid, $prev_next){
		var log = $("#err");
		log.attr('title', '页面跳转错误');
		
		if($prev_next == 'prev'){
			log.html(
				'<p>总共整理了' + $count + '页</p>' +
				'<p>当前第' + $pid + '页</p>' +
				'<p>已经是最前一页</p>'
			);
		}else if($prev_next == 'next'){
			log.html(
				'<p>总共整理了' + $count + '页</p>' +
				'<p>当前第' + $pid + '页</p>' +
				'<p>已经是最后一页</p>'
			);
		}
		log.dialog({
			bgiframe: true,
			modal: false,
			resizable: true,
			autoOpen: false,
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				}
			}
		});
		log.dialog('open');
	}
	function show_link_log($count){
		var log = $("#page_info");
		log.attr('title', '导航列表:总共整理了'+$count+'页&nbsp;&nbsp;&nbsp;格式:<span style="color:#000000;font-size:12px;line-height:1.3;padding-top:2px;padding-bottom:2px;background:#DEE7F8;">页数(楼主发帖数)</span>');		
		log.dialog({
			bgiframe: true,
			modal: false,
			width: 800,
			resizable: true,
			autoOpen: false,
			buttons: {
				关闭: function() {
					$(this).dialog('close');
				}
			}
		});
		log.dialog('open');
	}
    var $tid = Number($("#page_info").attr('tid'));
    var $pid = Number($("#page_info").attr('pid'));
    var $count = Number($("#page_info").attr('count'));
    //alert($tid,$pid,$count);
    $("span.prev")
    .css({"text-decoration":"underline","color":"blue","background":"#DEE7F8","padding-left":"0px","padding-top":"4px","padding-right":"2px","padding-bottom":"4px"})
    .css("cursor", "pointer").click(function () {
    	var $to_pid = ($pid - 1);
    	if($to_pid > 0){
    		$("a.jump").each(function(){
    			if($(this).attr('pid') == $to_pid){
    				var $link = $(this).attr('href');
    				window.location.href=$link;
    			}
    		});
    	}else{
    		show_nav_log($count, $pid, 'prev');
    	}
    });
    $("span.next")
    .css({"text-decoration":"underline","color":"blue","background":"#DEE7F8","padding-left":"2px","padding-top":"4px","padding-right":"0px","padding-bottom":"4px"})
    .css("cursor", "pointer").click(function () {
    	var $to_pid = ($pid + 1);
    	if($to_pid <= $count){
    		$("a.jump").each(function(){
    			if($(this).attr('pid') == $to_pid){
    				var $link = $(this).attr('href');
    				window.location.href=$link;
    			}
    		});
    	}else{
    		show_nav_log($count, $pid, 'next');
    	}   	
    });    
    $("span.current")
    .css({"text-decoration":"underline","color":"blue","background":"#DEE7F8","padding-left":"0px","padding-top":"4px","padding-right":"0px","padding-bottom":"4px"})
    .css("cursor", "pointer").click(function () {
    	show_link_log($count);
    });  
    
    
    //ui样式
    $("div.section").each(function(){
    	$(this).children("div.blog").addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active").hide();
    	$(this).children("h4.blog_author").addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").hide();
    });
    $("#lists").addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active");
	$("h3").addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all");
        
	//窗口定位
    $window.resize(function () {
        $wrap.width(Math.min($window.width(), maxWidth)).css({"position":"absolute", "display":"block"});
        $wrap.center({
        	"vertical": false
        });
        

        //if ($history_panel.length) {		//显示在最上层
        //    $history_panel.css({"margin-left":($window.width()-$history_panel.width()-10), "z-index":9, "position":"absolute", "display":"block", "top":0, "overflow":hidden});            
        //} 
        //if ($history_panel.length) {
            //$history_panel.css("left", ($window.width() + maxWidth) / 2 + 2)
        	//$history_panel.css("left", (($window.width() - maxWidth) / 2) + maxWidth)
        
        $tools_panel.css("display","block");
    	if(binfo == 'IE'){
    		$tools_panel.css({"right":((($window.width() - maxWidth) / 2)-140)+"px", "text-align":"right", "position":"absolute"})
    	}else if(binfo == 'FF'){
    		//$history_panel.css({"right":"0", "text-align":"right", "position":"absolute"})
    		$tools_panel.css("left", (($window.width() - maxWidth) / 2) + maxWidth);
    		$("#lists").hide('fast');
    		$("#lists").show('fast');
    	}
        //} 
        
    }).resize(); 

});