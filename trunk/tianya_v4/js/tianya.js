;
$(function () {
	$("#wrap").hide();
	$("#history_panel").hide();
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
    var $history_panel = $("#history_panel");
    var maxWidth = 800;
    var body_width = document.body.offsetWidth;
    var contents = "";
    var author_md5 = $("#first_author").attr('name');
    
    var bro=$.browser;	//浏览器版本
    var binfo="";
    if(bro.msie) {binfo="IE"}
    if(bro.mozilla) {binfo="FF"}
    if(bro.safari) {binfo="SF"}
    if(bro.opera) {binfo="OP"}
    //alert(binfo);
    
    //$wrap.hide();
    //$history_panel.hide();

    //用户列表和跳转
    $("div.section h4:has(a)").each(function () {
        var $childrenAname = $(this).children("a").attr("name");
        var name = $(this).attr("name");
        contents += '<li name="'+ name +'" style="display:inline">' 
        	+ $(this).children("span").text() 
        	+ '<a href="' + url + '#' + $childrenAname + '" scrollto="' + $childrenAname + '"></a></li>';
    });
    contents = '<ol>' + contents + '</ol>';   
    $("#contents").html(contents);  
  
    //打开作者标题栏
   	$("#contents li").each(function () {}).css("cursor", "pointer").click(function (){
   		var name = $(this).attr('name');
    	$("div.section h4").each(function () {
    		var the_name = $(this).attr('name');    
    		if(the_name == name){
    			$(this).show("normal");
    		}
    	});  
    	if(binfo == 'FF'){
    		$("#contents").hide('fast');
    	}
    	$("#contents li").each(function () {
    		var the_name = $(this).attr('name');
    		if(the_name == name){
    			$(this).hide();
    		}    		
    	});    	
    	if(binfo == 'FF'){
    		$("#contents").show('fast');
    	}
   	});   
   	$("#contents li").css({
   		"border-top-width":"1px",
   		"border-right-width-value":"1px",
   		"border-right-width-ltr-source":"physical",
   		"border-right-width-rtl-source":"physical",
   		"border-bottom-width":"1px",
   		"border-left-width-value":"1px",
   		"border-left-width-ltr-source":"physical",
   		"border-left-width-rtl-source":"physical",
   		"border-top-style":"solid",
   		"border-right-style-value":"solid",
   		"border-right-style-ltr-source":"physical",
   		"border-right-style-rtl-source":"physical",
   		"border-bottom-style":"solid",
   		"border-left-style-value":"solid",
   		"border-left-style-ltr-source":"physical",
   		"border-left-style-rtl-source":"physical",
   		"border-top-color":"#cad8f3",
   		"border-right-color-value":"#cad8f3",
   		"border-right-color-ltr-source":"physical",
   		"border-right-color-rtl-source":"physical",
   		"border-bottom-color":"#cad8f3",
   		"border-left-color-value":"#cad8f3",
   		"border-left-color-ltr-source":"physical",
   		"border-left-color-rtl-source":"physical",
   		"background-color":"#dee7f8",
   		"background-image":"none",
   		"background-repeat":"repeat",
   		"background-attachment":"scroll",
   		"background-position":"0% 0%",
   		"padding-top":"1px",
   		"padding-right":"15px",
   		"padding-bottom":"2px",
   		"padding-left":"5px",
   		"margin-right":"5px",
   		"margin-bottom":"4px",
   		"-moz-background-clip":"border",
   		"-moz-background-inline-policy":"continuous",
   		"-moz-background-origin":"padding",
   		"-moz-border-radius-bottomleft":"6px",
   		"-moz-border-radius-bottomright":"6px",
   		"-moz-border-radius-topleft":"6px",
   		"-moz-border-radius-topright":"6px",
   		"position":"relative"
   	}).each(function () {   	   		
   		if(binfo == 'FF'){
   			$(this).append('<span style="position:absolute;right:0" class="ui-icon ui-icon-check"></span>');
   		}else{
   			$(this).append('<span style="position:absolute;" class="ui-icon ui-icon-check"></span>');
   		}
   	});
   	$("#contents ol").css({
   		"margin-top":"0pt",
   		"margin-right":"0pt",
   		"margin-bottom":"0pt",
   		"margin-left":"0pt",
   		"border-top-width":"1px",
   		"border-right-width-value":"1px",
   		"border-right-width-ltr-source":"physical",
   		"border-right-width-rtl-source":"physical",
   		"border-bottom-width":"1px",
   		"border-left-width-value":"1px",
   		"border-left-width-ltr-source":"physical",
   		"border-left-width-rtl-source":"physical",
   		"border-top-style":"solid",
   		"border-right-style-value":"solid",
   		"border-right-style-ltr-source":"physical",
   		"border-right-style-rtl-source":"physical",
   		"border-bottom-style":"solid",
   		"border-left-style-value":"solid",
   		"border-left-style-ltr-source":"physical",
   		"border-left-style-rtl-source":"physical",
   		"border-top-color":"#999999",
   		"border-right-color-value":"#999999",
   		"border-right-color-ltr-source":"physical",
   		"border-right-color-rtl-source":"physical",
   		"border-bottom-color":"#999999",
   		"border-left-color-value":"#999999",
   		"border-left-color-ltr-source":"physical",
   		"border-left-color-rtl-source":"physical",
   		"overflow-x":"hidden",
   		"overflow-y":"hidden",
   		"height":"auto",
   		"padding-top":"4px",
   		"padding-right":"5px",
   		"padding-bottom":"0pt",
   		"padding-left":"5px"
   	});
   	
    var backtocontent = '<span style="float:right;position:relative;" class="open ui-icon ui-icon-gear"></span><p class="backToTop">';
    backtocontent += '<a href="' + url + '#content" scrollto="content">↑返回用户列表</a>';
    backtocontent += '</p>';
    $("div.blog").append(backtocontent);

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
    		$("#contents").hide();
    	}
       	$("#contents li").each(function () {
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
    		$("#contents").show('fast');
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
    	$("#contents li").each(function () {
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
			$("#contents").hide('fast');
		}
		$("#contents li").each(function () {
			var the_name = $(this).attr("name");
			if(the_name == name){
				$(this).hide();
				$(this).css('display', 'inline');
				$(this).show();
			}
		});	
		if(binfo == 'FF'){
			$("#contents").show('fast');
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
	    			$("td.lz").text('隐藏楼主帖子');
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
	    			$("td.lz").text('显示楼主帖子');
	    		}
    		});		
    	}
    });


	//显示当前标题内容
    $("h3 > span").css("cursor", "pointer").click(function () {
    	$("#contents").slideToggle('normal');
    });   
    $("h4 > span").css("cursor", "pointer").click(function () {
    	$(this).parent().next("div.blog").slideToggle('normal');
    	var st = $(this).parent().children("div.tools").children("span");
    	//alert(st.attr('class'))    	
    	if(st.attr('class') == 'ui-icon ui-icon-circle-minus'){
    		st.removeClass();
    		st.addClass('ui-icon ui-icon-circle-plus');
    	}else if(st.attr('class') == 'ui-icon ui-icon-circle-plus'){
    		st.removeClass();
    		st.addClass('ui-icon ui-icon-circle-minus');
    	}

    });   

    
    //显示楼主功能
    $("td.lz").css({"text-decoration":"underline","color":"blue"}).css("cursor", "pointer").click(function () {
    	var c = $(this).text();
    	if(binfo == 'FF'){
    		$("#contents").hide();
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
	    	$(this).text('隐藏楼主帖子');
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
	    	$(this).text('显示楼主帖子');
    	}
    	if(binfo == 'FF'){
    		$("#contents").show('fast');
    	}
    });
    //打开全部作者
    $("td.allzz").css({"text-decoration":"underline","color":"blue"}).css("cursor", "pointer").click(function () {
    	var c = $(this).text();
    	if(binfo == 'FF'){
    		$("#contents").hide();
    	}
    	if(c == '打开全部作者'){
	    	$("div.section h4").each(function () {
	    		$(this).show('fast');
	    	});
	    	$("#contents li").each(function () {
	    		$(this).hide();
	    	});	    
	    	$("#contents").hide();
	    	$(this).text('关闭全部作者');
    	}else if(c == '关闭全部作者'){
	    	$("div.section h4").each(function () {
	    		$(this).hide();
	    	});
	    	$("#contents li").each(function () {
	    		$(this).css('display', 'inline');
	    		$(this).show('fast');
	    	});	
	    	$("#contents").show('fast');
	    	$("div.blog").each(function () {
	    		$(this).hide();
	    	});	    
	    	$("div.section div.tools").each(function () {
	    		st = $(this).children("span");
	    		st.removeClass();
	    		st.addClass('ui-icon ui-icon-circle-plus');
	    	});
	    	$(this).text('打开全部作者');
	    	if(binfo == 'FF'){
	    		$("#contents").show('fast');
	    	}
    	}
    });   
    
    //ui样式
    $("div.section").each(function(){
    	$(this).children("div.blog").addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active").hide();
    	$(this).children("h4.blog_author").addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all").hide();
    });
    $("#contents").addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active");
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
        $history_panel.css("display","block");
    	if(binfo == 'IE'){
    		$history_panel.css({"right":((($window.width() - maxWidth) / 2)-140)+"px", "text-align":"right", "position":"absolute"})
    	}else if(binfo == 'FF'){
    		//$history_panel.css({"right":"0", "text-align":"right", "position":"absolute"})
    		$history_panel.css("left", (($window.width() - maxWidth) / 2) + maxWidth);
    		$("#contents").hide('fast');
    		$("#contents").show('fast');
    	}
        //} 
        
    }).resize(); 

});