var $fx_ajax = ''; //ajax返回数据
var d = new Date();
var time_start = d.getTime();
var time_start_collation = 0;		//整理开始时间
var cpcount = 0;					//整理页数统计


$.ajaxSetup({
	type: "post",
	url: 'index.php?r=snoopy/save',
	dataType: "json",
	cache: false,
	timeout: 60000,
	beforeSend: function(XMLHttpRequest){
		$("#gurl")[0].disabled = true;
		setTimeout(function(){},1000);
	},
	success: next,
	complete: function(XMLHttpRequest, textStatus){
		setTimeout(function(){},1000);
	},
	error: function(){
		disable_gurl(false);
		setTimeout(function(){},1000);
	}
});

function run_ajax(){
	if($fx_ajax != ''){
		$.ajax({
		
			data: 'pid=' + $fx_ajax['pid']
			       + '&pcount=' + $fx_ajax['pcount']
			       + '&type=' + $fx_ajax['type']
			       + '&furl=' + $fx_ajax['furl']
			       + '&channel_en=' + $fx_ajax['channel_en']
			       + '&list=' + $fx_ajax['list'],
		
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
	
	$("#furl").html('<span class="title">首页: </span>' + '<a href="' + data.furl + '">' + data.furl + '</a>');
	$("#channel_cn").html('<span class="title">频道: </span>' + data.channel_cn);
	$("#title").html('<span class="title">标题: </span>' + data.title);
	$("#author_name").html('<span class="title">作者: </span>' + data.author_name);
	$("#pcount").html('<span class="title">总页数: </span>' + data.pcount);
	$("#pid").html('<span class="title">当前页: </span>' + data.pid);
	
	$("#url").attr('disabled','disabled');
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
	if(time_start_collation == 0){
		var d = new Date();
		time_start_collation = d.getTime();
	}
	cpcount = 0;
	run_ajax();
}
//进入下一页整理
function next(data){
	if(data != $fx_ajax['pid']){
		disable_gurl(false);
		return false;
	}
	
	var d = new Date();
	var time_new = d.getTime();
	var use_time = (time_new-time_start_collation)/1000;
	cpcount++;
	var cpptime  = use_time/cpcount;	
	
	$("#pid").html('<span class="title">当前页: </span>' + data);
	$("#runtimes").html('<span class="title">整理用时: </span>' + use_time + '秒');
	$("#cpcount").html('<span class="title">本次整理: </span>' + cpcount + '页');
	$("#cpptime").html('<span class="title">每页整理用时: </span>' + cpptime + '秒');
	
	$fx_ajax['pid']++;
	
	//setTimeout(function(){
		progress($fx_ajax['pcount'],$fx_ajax['pid']);
	//},1000);
	

	if($fx_ajax['pid'] <= $fx_ajax['pcount']){
		run_ajax();
	}else{
		alert('采集完成');
		disable_gurl(false);
	}
}

//更新进度条
function progress(pcount,pid){
	var _one_len = 600;
	var _last_len = pcount % _one_len;		//最后一行进度条长度
	var _first_len = pcount-_last_len;		//
	if(_first_len >= _one_len){
		var _cut_num = _first_len/_one_len;	//进度条整段数
	}else{
		var _cut_num = 0;
	}
	
	//进度条数据框架
	var $progress_html = '';
	var _out  = _one_len;
	var _in   = '';
	for(i=1; i<=_cut_num; i++){
		if(pid>_one_len){
			_in = _one_len;
			pid -= _one_len;
		}else if(pid>0){
			_in = pid;
			pid = 0;
		}else{
			_in = 0;
		}
		$progress_html += '<div class="progressout" style="width:'
			+_out+'px;"><div class="progressin" style="width:'
			+_in+'px;"></div></div>';
	}

	$progress_html += '<div class="progressout" style="width:'
		+_last_len+'px;"><div class="progressin" style="width:'
		+pid+'px;"></div></div>';
	$("#progress").html($progress_html);
	//alert($progress_html);
}
