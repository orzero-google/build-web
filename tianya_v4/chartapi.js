;
(function ($) {
    var $scrollTo = $.scrollTo = function (target, duration, settings) {
        $scrollTo.window().scrollTo(target, duration, settings)
    };
    $scrollTo.defaults = {
        axis: 'y',
        duration: 1
    };
    $scrollTo.window = function () {
        return $($.browser.safari ? 'body' : 'html')
    };
    $.fn.scrollTo = function (target, duration, settings) {
        if (typeof duration == 'object') {
            settings = duration;
            duration = 0
        }
        settings = $.extend({},
        $scrollTo.defaults, settings);
        duration = duration || settings.speed || settings.duration;
        settings.queue = settings.queue && settings.axis.length > 1;
        if (settings.queue) duration /= 2;
        settings.offset = both(settings.offset);
        settings.over = both(settings.over);
        return this.each(function () {
            var elem = this,
                $elem = $(elem),
                t = target,
                toff, attr = {},
                win = $elem.is('html,body');
            switch (typeof t) {
            case 'number':
            case 'string':
                if (/^([+-]=)?\d+(px)?$/.test(t)) {
                    t = both(t);
                    break
                }
                t = $(t, this);
            case 'object':
                if (t.is || t.style) toff = (t = $(t)).offset()
            }
            $.each(settings.axis.split(''), function (i, axis) {
                var Pos = axis == 'x' ? 'Left' : 'Top',
                pos = Pos.toLowerCase(),
                key = 'scroll' + Pos,
                act = elem[key],
                Dim = axis == 'x' ? 'Width' : 'Height',
                dim = Dim.toLowerCase();
                if (toff) {
                    attr[key] = toff[pos] + (win ? 0 : act - $elem.offset()[pos]);
                    if (settings.margin) {
                        attr[key] -= parseInt(t.css('margin' + Pos)) || 0;
                        attr[key] -= parseInt(t.css('border' + Pos + 'Width')) || 0
                    }
                    attr[key] += settings.offset[pos] || 0;
                    if (settings.over[pos]) attr[key] += t[dim]() * settings.over[pos]
                } else attr[key] = t[pos];
                if (/^\d+$/.test(attr[key])) attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max(Dim));
                if (!i && settings.queue) {
                    if (act != attr[key]) animate(settings.onAfterFirst);
                    delete attr[key]
                }
            });
            animate(settings.onAfter);



            function animate(callback) {
                $elem.animate(attr, duration, settings.easing, callback &&
                function () {
                    callback.call(this, target)
                })
            };



            function max(Dim) {
                var el = win ? $.browser.opera ? document.body : document.documentElement : elem;
                return el['scroll' + Dim] - el['client' + Dim]
            }
        })
    };



    function both(val) {
        return typeof val == 'object' ? val : {
            top: val,
            left: val
        }
    }
})(jQuery);
$(document).ready(function () {
    var url = "";
    var $window = $(window);
    var $wrap = $("#wrap");
    var maxWidth = 760;
    var contents = "";
    var author_md5 = $("#author").attr('value');
    
    //$("div.section h4:has(a)").each(function () {
    $("div.section h4:has(a)").each(function () {
        var $childrenAname = $(this).children("a:first").attr("name");
        contents += '<li lname="'+$(this).attr('tname')+'" style="display:inline; border: 0px; padding:2px;">' 
        + $(this).text() + '<a href="' + url + '#' + $childrenAname + '" scrollto="' + $childrenAname + '"></a>';
        var $childrenH5 = $(this).next("div.scrap").children("h5:has(a)");
        if ($childrenH5.length) {
            contents += ' <span class="switch">+</span><ul>';
            $childrenH5.each(function () {
                var $childrenAname = $(this).children("a:first").attr("name");
                contents += '<li><a href="' + url + '#' + $childrenAname + '" scrollto="' + $childrenAname + '">' + $(this).text() + '</a></li>'
            });
            contents += '</ul>'
        }
        contents += '</li>'
    })/*.css("cursor", "pointer").click(function () {
    	var pname = $(this).children("div[class='tool']").attr("pname");
    	$("div[class='scrap']").each(function () {
    		if($(this).attr('cname') == pname)
    			$(this).slideToggle("fast");
    	});
        //$(this).next("div.scrap").slideToggle("fast")
    });*/
    //alert($("div.section div.tools").parents().next("div.scrap").html());
    
    $("div.section div.tools").each(function () {
    	$(this).css({'position':'absolute','right':'10px','width':'10%','display':'inline','background-color':'#ffffff'});
    	$(this).text('+');
    	/*
    	$(this).css("cursor", "pointer").toggle(function () {
            $(this).text("-")
        },
        function () {
            $(this).text("+")
        }).click(function () {
            $(this).next("ul").toggle()
        });*/
    }).css("cursor", "pointer").click(function () {
    	var st = $(this).text();
    	var name = $(this).attr("name");
    	if(st == '+'){
    		$("div.section div.tools").each(function () {
    			var the_name = $(this).attr("name");
    			if(the_name == name){
    				$(this).text('-');
    			}
    		});
        	$("div[class='scrap']").each(function () {
        		var the_name = $(this).attr('cname');
        		if(the_name == name)
        			$(this).show("slow");
        	});    		
    	}else if(st == '-'){
    		$("div.section div.tools").each(function () {
    			var the_name = $(this).attr("name");
    			if(the_name == name){
    				$(this).text('+');
    			}
    		});
        	$("div[class='scrap']").each(function () {
        		var the_name = $(this).attr('cname');
        		if(the_name == name)
        			$(this).hide("normal");
        	});        		
    	}
    });
    
 
    /*.css("cursor", "pointer").click(function () {
    	var pname = $(this).attr("name");
    	$("div[class='scrap']").each(function () {
    		if($(this).attr('cname') == pname)
    			$(this).slideToggle("fast");
    	});
        //$(this).next("div.scrap").slideToggle("fast")
    }).toggle(function () {
    	var pname = $(this).attr("name");
    	$("div.section div.tools").each(function () {
    		if($(this).attr('name') == pname)   	
    			$(this).text("-")
    	});
    },
    function () {
    	var pname = $(this).attr("name");
    	$("div.section div.tools").each(function () {
    		if($(this).attr('name') == pname)   	
    			$(this).text("+")
    	});
    });*/
    
    //alert($("div.section code").html());
    //$("div.section div[class='tool']").each(function () {}).css("cursor", "pointer").click(function () {
    $("div.section code").each(function () {}).css("cursor", "pointer").click(function () {
    	$(this).parent().parent().next("div.scrap").slideToggle("fast");
    	var st = $(this).parent().parent().children("div.tools");
    	//alert(st);
    	if(st.text() == '+'){
    		st.text('-');
    	}else{
    		st.text('+');
    	}
    });    
    
    contents = '<ol>' + contents + '</ol>';
    $("#content").html(contents);
    $("#content span.switch").css("cursor", "pointer").toggle(function () {
        $(this).text("-")
    },
    function () {
        $(this).text("+")
    }).click(function () {
        $(this).next("ul").toggle()
    });
    $('img').lazyload({
        placeholder: "grey.gif",
        effect: "fadeIn"
    });
    
    $("#content").hide();
    $("h3").append('<div class="author_t">author@</div>');
    $("h3 div.author_t").css({'position':'absolute','right':'10px','width':'12%','display':'inline','background-color':'#ffffff'})
    .css("cursor", "pointer").click(function () {
    	$("#content").slideToggle("fast");
    });
    
    //显示楼主功能
    $("td.lz").css({"text-decoration":"underline","color":"blue"}).css("cursor", "pointer").click(function () {
    	var c = $(this).text();
    	if(c == '显示楼主帖子'){
	    	$("div.scrap").each(function () {
	    		var name=$(this).attr('cname');
	    		var i = 0;
	    		if(name == author_md5){
	    			$(this).show('fast');
	    			i++;
	    		}
	    		if(i = 0){
	    			//alert('当前页楼主没有发帖');
	    		}
	    	});
	    	$(this).text('隐藏楼主帖子');
    	}else if(c == '隐藏楼主帖子'){
	    	$("div.scrap").each(function () {
	    		var name=$(this).attr('cname');
	    		var i = 0;
	    		if(name == author_md5){
	    			$(this).hide();
	    			i++;
	    		}
	    		if(i = 0){
	    			//alert('当前页楼主没有发帖');
	    		}
	    	});
	    	$(this).text('显示楼主帖子');
    	}
    });
    //打开全部作者
    $("td.allzz").css({"text-decoration":"underline","color":"blue"}).css("cursor", "pointer").click(function () {
    	var c = $(this).text();
    	if(c == '打开全部作者'){
	    	$("div.section h4").each(function () {
	    		$(this).show('fast');
	    	});
	    	$("#content li").each(function () {
	    		$(this).hide();
	    	});	    
	    	$("#content").hide();
	    	$(this).text('关闭全部作者');
    	}else if(c == '关闭全部作者'){
	    	$("div.section h4").each(function () {
	    		$(this).hide();
	    	});
	    	$("#content li").each(function () {
	    		$(this).css('display', 'inline');
	    		$(this).show('fast');
	    	});	
	    	$("#content").show('fast');
	    	$(this).text('打开全部作者');
    	}
    });
    
    //显示楼主帖子标题栏目    
    //alert(author_md5);
	$("div.section h4:has(a)").each(function () {
		var the_name = $(this).attr("tname");
		var i = 0;
		if(the_name == author_md5){
			$(this).show("fast");
			i++;
		}
		
	});    
	
    //高亮楼主
	$("p[id='content'] li").each(function () {
		var lname = $(this).attr('lname');
		if(lname == author_md5){
			$(this).css("background-color", '#20b2aa').hide();
		}
	});   
	$("code").each(function () {
		var name = $(this).attr('name');
		if(name == author_md5){
			$(this).css({'background-color':'#20b2aa',"color":'#000000'});
		}
	});
	
	//标题栏关闭按钮
    $("div.section div.sw").each(function () {
    	$(this).css({'position':'absolute','right':'100px','width':'10%','display':'inline','background-color':'#ffffff'});
    	$(this).text('x');
    }).css("cursor", "pointer").click(function () {
    	var name = $(this).attr("name");

		$("div.section h4").each(function () {
			var the_name = $(this).attr("tname");
			if(the_name == name){
				$(this).hide();
			}
		});
    	$("#content li").each(function () {
    		var the_name = $(this).attr('lname');
    		if(the_name == name){
    			$(this).css('display', 'inline');
    			$(this).show("slow");    			
    		}
    	});    		
    	$("#content").show("fast");
    });   
    //xami add
   	//var author_base64 = base64_encode($("meta[name='author']").attr('content'));
   	//alert($("#content li").html());
   	/*
   	$("#content li").each(function () {
   		//alert(this);
   		var tname = $(this).attr('name');
   		 			
   	}).css("cursor", "pointer").click(function (){
    	$("h4").each(function () {
    		if($(this).attr('cname') == tname){
    			//$(this).slideToggle("fast");
    			alert(tname); 
    		}
    	});  
   	});*/
   	$("#content li").each(function () {}).css("cursor", "pointer").click(function (){
   		var lname = $(this).attr('lname');
   		//alert($("div.section h4").html());
   		//alert(lname+'[lname]');
    	$("div.section h4").each(function () {
    		var tname = $(this).attr('tname');    
    		//alert(tname);
    		if(tname == lname){
    			//alert(tname);
    			$(this).slideToggle("slow");//alert(tname);
    		}
    	});  
    	$("#content li").each(function () {
    		var the_name = $(this).attr('lname');
    		if(the_name == lname){
    			$(this).hide();    			
    		}
    	});    
    	$("#content").hide();
   	});   	
    //xami end
    
    var backtocontent = '<p class="backToTop">';
    backtocontent += '<a href="' + url + '#contents" scrollto="contents">↑返回作者列表</a>';
    backtocontent += '</p>';
    $("h5,h6").before(backtocontent);
    $("div.scrap").append(backtocontent);
    var $history_list = $("#history_list");
    var history_i = 0;
    jQuery.fn.bindScroll = function (f) {
        return this.click(function () {
            $.scrollTo("a[name=" + $(this).attr("scrollto") + "]", {
                speed: 500,
                axis: 'y',
                offset: {
                    top: -24,
                    left: 0
                }
            });
            return false
        })
    };
    $("a[scrollto!=]").each(function () {
        $(this).bindScroll().click(function () {
            var $thisScrollTo = $(this).attr('scrollto');
            if (history_panel.length && $thisScrollTo != 'contents') {
                $('<a href="#' + $thisScrollTo + '" scrollto="' + $thisScrollTo + '">' + $(this).text() + '</a>').bindScroll().prependTo($history_list).wrapAll('<tr><td></td></tr>');
                history_i++;
                if (history_i > 7) {
                    $history_list.children("tr:last-child").remove()
                }
            }
        })
    });
    //$("a:not([href^=http://localhost:8080/])").attr("target", "_blank");
    var history_panel = $("#history_panel");
    if (history_panel.length && $.browser.msie && $.browser.version < 7) {
        history_panel.css("position", "absolute");
        $window.scroll(function () {
            history_panel.css("top", $window.scrollTop() + 20)
        })
    }
    $window.resize(function () {
        $wrap.width(Math.min($window.width(), maxWidth));
        if (history_panel.length) {
            history_panel.css("left", ($window.width() + maxWidth) / 2 + 2)
        }
    }).resize();

});
