;
$(function () {
	//$("#wrap").hide();
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

$(document).ready(function(){
    var url = "";
    var $window = $(window);
    var $wrap = $("#wrap");
    var history_panel = $("#history_panel");
    var maxWidth = 800;
    var body_width = document.body.offsetWidth;
    var contents = "";
    var author_md5 = $("#first_author").attr('name');
    
    $wrap.hide();
    

    //用户列表和跳转
    $("div.section h4:has(a)").each(function () {
        var $childrenAname = $(this).children("a").attr("name");
        var name = $(this).attr("name");
        contents += '<li name="'+ name +'" style="display:inline">' 
        	+ $(this).text() 
        	+ '<a href="' + url + '#' + $childrenAname + '" scrollto="' + $childrenAname + '"></a></li>';
    });
    contents = '<ol>' + contents + '</ol>';   
    $("#contents").html(contents);  
    
    //打开作者标题栏
   	$("#contents li").each(function () {}).css("cursor", "pointer").click(function (){
   		var name = $(this).attr('name');
    	$("div.section h4").each(function () {
    		var tname = $(this).attr('name');    
    		if(tname == name){
    			$(this).slideToggle("fast");
    		}
    	});  
    	//$("#contents").hide();
   	});   
    var backtocontent = '<p class="backToTop">';
    backtocontent += '<a href="' + url + '#contents" scrollto="contents">↑返回用户列表</a>';
    backtocontent += '</p>';
    $("div.blog").append(backtocontent);

    //显示楼主帖子标题栏目    
    //alert(author_md5);
	$("div.section h4").each(function () {
		var the_name = $(this).attr("name");
		var i = 0;
		if(the_name == author_md5){
			$(this).show("fast");
			i++;
		}
	}); 

/*	
	//显示当前作者所有内容
    $("div.section div.tools").each(function () {
    	$(this).css({"margin-left":"700px", "z-index":10, "width":"20px", "display":"block"});
    	$(this).html('<span class="ui-icon ui-icon-circle-plus"/>');
    }).css("cursor", "pointer").click(function () {
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
    		});		
    	}
    });
*/
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

        /*
        if (history_panel.length) {		//显示在最上层
            history_panel.css({"margin-left":($window.width()-history_panel.width()-10), "z-index":9, "position":"absolute", "display":"block", "top":0, "overflow":hidden});            
        } */
        if (history_panel.length) {
            history_panel.css("left", ($window.width() + maxWidth) / 2 + 2)
        } 
        
    }).resize(); 
    
});