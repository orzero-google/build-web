var $fx_ajax = ''; //ajax返回数据
$.ajaxSetup({
	type: "post",
	url: 'index.php?r=snoopy/save',
	dataType: "json",
	cache: false,
	timeout: 60000,
	beforeSend: function(XMLHttpRequest){
		$("#gurl")[0].disabled = true;
	},
	success: next,
	/*
	success: function(data, textStatus){
		disable_gurl(false);

		
		//编码引起有隐含字符附加在data前
		if(binfo=="FF"){
			var source_data = data.toSource();
			//alert(source_data);
			var end = source_data.lastIndexOf('"');
			var start = source_data.indexOf('FEFF') + 4;
			//start = 19;
			if((start != -1) && (end != -1)){
			//if(end != -1){
				//var str_data = source_data.slice(start, end).replace(/\\/g, '').replace(/\"/g, '');
				//var json_data = $.toJSON(str_data);
				//var page_id = $.evalJSON(str_data).pid;
				var page_id = source_data.slice(start, end);
			}				
		//if(number_data == page)
		//alert(str_data.replace(/\\/g, ''));
		//alert(str_data);
		//alert(json_data);
		//alert(page_id);
		//alert(the_link +'_'+ count_link);
		}else{
			var page_id = data;
		}
		if(the_link == count_link){
			suc();
			return;
		}
		if(page_id == page){
			$("#link_list").attr('value', page);	//成功,计数器+1
			if(the_link < count_link && run == 1){
				run_start();
			}
		}else{
			err();
			//alert(the_link +'_'+ count_link);
		}

	},
*/
	complete: function(XMLHttpRequest, textStatus){
		//$("#link_list").attr('status', 'start');
	},
	error: function(){
		disable_gurl(false);
	}
});

function run_ajax(){
	if($fx_ajax != ''){
		$.ajax({
		
			data: 'pid=' + $fx_ajax['pid']
			       + '&type=' + $fx_ajax['type']
			       + '&furl=' + $fx_ajax['furl']
			       + '&list=' + $fx_ajax['list']
			       + '&channel_en=' + $fx_ajax['channel_en']
			       + '&pcount=' + $fx_ajax['pcount'],
		
		}); 
	}
}

function showinfo(data){
	if(data.length){
		alert(data);
		$("#surl")[0].disabled = false;
		return false;
	}
	$fx_ajax = data;		//更新全局变量
	
	//$("#msg").html(data);
	//alert(data.list);
	
	$("#channel_cn").html('<span class="title">频道: </span>' + data.channel_cn);
	$("#title").html('<span class="title">标题: </span>' + data.title);
	$("#author_name").html('<span class="title">作者: </span>' + data.author_name);
	$("#pcount").html('<span class="title">总页数: </span>' + data.pcount);
	$("#pid").html('<span class="title">当前页: </span>' + data.pid);		
	$("#furl").html('<span class="title">首页: </span>' + '<a href="' + data.furl + '">' + data.furl + '</a>');

	$("#ret").show();
	$("#gurl").show();
	$("#surl").hide();
}

//ajax调用前准备
function beforeSend(){
	$("#surl")[0].disabled = true;
}
//ajax调用出错
function error(){
	$("#surl")[0].disabled = false;
}

function disable_gurl(bool){
	$("#gurl")[0].disabled = bool;
}

//构造链接
function mkurl($list, $pid, $type){
	
}
//整理功能
function collation(){
	//alert($fx_ajax.list[3]);
	run_ajax();
}
//进入下一页整理
function next(){
	//alert('goods');
	$fx_ajax['pid']++;
	if($fx_ajax['pid'] <= $fx_ajax['pcount']){
		run_ajax();
	}else{
		disable_gurl(false);
	}
}