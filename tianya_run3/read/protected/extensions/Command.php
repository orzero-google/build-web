<?php
function is_url($url){
    $url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
    if ( !$url || $url=="" ) return false;
    if ( !( $parts = @parse_url( $url ) ) ) return false;
    else {
    	if (!isset($parts['scheme'])) return false;
        if ( $parts['scheme'] != "http" && $parts['scheme'] != "https" /*&& $parts['scheme'] != "ftp" && $parts['scheme'] != "gopher"*/ ) return false;
        
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

//取得中间字符串
function get_mid_content($str, $startmark, $endmark){
	//c1 c2[mark:end]c3
	$temp1 = explode($startmark, $str, 2);
	
	//是否找到前端字符
	if( !isset($temp1[1]) ){
		return false;
	}	

	$temp2 = explode($endmark, $temp1[1], 2);	
	if( !isset($temp2[1]) ){
		return false;
	}	

	$out = $temp2[0];
	return($out);
}

function utf82gbk($str){
	return iconv('UTF-8', 'GBK//IGNORE', $str);
}

function gbk2utf8($str){
	return iconv('GBK', 'UTF-8//IGNORE', $str);
}
