<?php 
//取得中间字符串
function get_mid_content($str, $startmark, $endmark){
	//c1 c2[mark:end]c3
	$temp1 = explode($startmark, $str, 2);
	
	//是否找到前端字符
	if( !isset($temp1[1]) ){
		return false;
	}	

	$temp2 = explode($endmark, $temp1[1]);	
	if( !isset($temp2[1]) ){
		return false;
	}
	
	return $temp2[0];
}

//检查目标是否正确的网址
function is_url($url){
	$url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
	if ( !$url || $url=="" ) return false;
	if ( !( $parts = @parse_url( $url ) ) ) return false;
	else {
		if (!isset($parts['scheme'])) return false;
		if ( $parts['scheme'] != "http" && $parts['scheme'] != "https" && $parts['scheme'] != "ftp" ) return false;
		else if (!isset($parts['host'])) return false;
		if ( !preg_match( "/^[0-9a-z]([-.]?[0-9a-z])*.[a-z]{2,4}$/i", $parts['host'], $regs ) ) return false;
		else if (isset($parts['user']))
			if ( !preg_match( "/^([0-9a-z-]|[_])*$/i", $parts['user'], $regs ) ) return false;
		else if (isset($parts['pass']))
			if ( !preg_match( "/^([0-9a-z-]|[_])*$/i", $parts['pass'], $regs ) ) return false;
		else if (isset($parts['path']))
			if ( !preg_match( "/^[0-9a-z\/_.@~-]*$/i", $parts['path'], $regs ) ) return false;
		else if (isset($parts['query']))
			if ( !preg_match( "/^[0-9a-z?&=#,]*$/i", $parts['query'], $regs ) ) return false;
	}
	return true;
}

//递归创建目录  
function mkdirs($pathname, $mode = 0755) {
	is_dir(dirname($pathname)) || mkdirs(dirname($pathname), $mode);
	return is_dir($pathname) || @mkdir($pathname, $mode);
}

//删除缓存文件,递归删除目录
function delFile(){
	$file = $this->file;
	if(@unlink($file)){
		$dir = dirname($file);
		while ($dir != $file):
			@rmdir($dir);
			$file = $dir;
			$dir = dirname($file);
		endwhile;
		return true;
	}
	return false;
}


function utf82gbk($str){
	return iconv("UTF-8", "GBK//IGNORE", $str);
}

function gbk2utf8($str){
	return iconv("GBK", "UTF-8//IGNORE", $str);
}

