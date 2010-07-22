var $ajax; //ajax返回数据
function showinfo(data){
	if(data.length){
		alert(data);
		$("#surl")[0].disabled = false;
		return false;
	}
	$ajax = data;		//更新全局变量
	
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

//构造链接
function mkurl($list, $pid, $type){
	
}
//整理功能
function collation(){
	//alert($ajax.list[3]);
}