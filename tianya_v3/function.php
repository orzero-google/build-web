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

	$out = $temp2[0];
	return($out);
}

//如果找到关键字,则取得关键字前面的字符
function get_bf($key_str_array, $str){

	if(is_array($key_str_array)){
		foreach ($key_str_array as $key){
			if($cut_tmp = explode($key, $str, 2)){
				$str = $out = $cut_tmp[0];
				//echo 'xami';
			}
	//		echo '<pre>';
	//		echo $out;
	//		echo '</pre>';
		}
	}else{
		if($cut_tmp = explode($key_str_array, $str, 2)){
			$out = $cut_tmp[0];
			//echo 'xami';
		}		
	}
	
	if(isset($out)){
		return $out;
	}else{
		return $str;
	}	
	
}

//如果找到关键字,则取得关键字后面的字符
function get_bh($key_str_array, $str){
	if(is_array($key_str_array)){
		foreach ($key_str_array as $key){
			if($cut_tmp = explode($key, $str)){
				$cut_count = count($cut_tmp);
				$str = $out = $cut_tmp[($cut_count - 1)];
			}
		}
	}else{
		if($cut_tmp = explode($key_str_array, $str)){
			$cut_count = count($cut_tmp);
			$out = $cut_tmp[($cut_count - 1)];
			//echo 'xami';
		}		
	}
	
	if(isset($out)){
		return $out;
	}else{
		return $str;
	}
}

//取得中间字符串列表
function get_mid_content_array($str, $startmark, $endmark){
	//c1 c2[mark:end]c3
	$temp1 = explode($startmark, $str);
	//print_r($temp1);
	if( !isset($temp1[1]) ){
		return false;
	}
	
	//c2[mark:end]c3
	$c = count($temp1);
	for($i=0; $i<$c; $i++){
		$temp2[] = explode($endmark, $temp1[$i]);
		//print_r($temp2);
	}
	
	//array(是否找到结束符,需要的字段);
	for($i=1; $i<$c; $i++){
		if( isset($temp2[$i][1]) ){
			$out[] = array(1,$temp2[$i][0]);
		}else{
			$out[] = array(0,$temp2[$i][0]);
		}
	}	

	if(!empty($out)){
		return($out);
	}else{
		return false;	
	}

}


//是否正确的网址
/**
 * Sanity check, is it really an URL?
 */
function is_url($url){
    $url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
    if ( !$url || $url=="" ) return false;
    if ( !( $parts = @parse_url( $url ) ) ) return false;
    else {
    	if (!isset($parts['scheme'])) return false;
        if ( $parts['scheme'] != "http" && $parts['scheme'] != "https" && $parts['scheme'] != "ftp" && $parts['scheme'] != "gopher" ) return false;
        
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


//判断网址是否存在
function page_exists($url)
{
   $parts = parse_url($url);
   if (!$parts) {
      return false; /* the URL was seriously wrong */
   }

   if (isset($parts['user'])) {
      return false; /* user@gmail.com */
   }

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);

   /* set the user agent - might help, doesn't hurt */
   //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; wowTreebot/1.0; +http://wowtree.com)');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

   /* try to follow redirects */
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

   /* timeout after the specified number of seconds. assuming that this script runs
      on a server, 20 seconds should be plenty of time to verify a valid URL.  */
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
   curl_setopt($ch, CURLOPT_TIMEOUT, 20);

   /* don't download the page, just the header (much faster in this case) */
   curl_setopt($ch, CURLOPT_NOBODY, true);
   curl_setopt($ch, CURLOPT_HEADER, true);

   /* handle HTTPS links */
   if ($parts['scheme'] == 'https') {
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   }

   $response = curl_exec($ch);
   curl_close($ch);

   /* allow content-type list */
   $content_type = false;
   if (preg_match('/Content-Type: (.+\/.+?)/i', $response, $matches)) {
       switch ($matches[1])
        {
           case 'application/atom+xml':
           case 'application/rdf+xml':
           //case 'application/x-sh':
           case 'application/xhtml+xml':
           case 'application/xml':
           case 'application/xml-dtd':
           case 'application/xml-external-parsed-entity':
           //case 'application/pdf':
           //case 'application/x-shockwave-flash':
              $content_type = true;
              break;
        }

       if (!$content_type && (preg_match('/text\/.*/', $matches[1]) || preg_match('/image\/.*/', $matches[1]))) {
           $content_type = true;
        }
   }

   if (!$content_type) {
      return false;
   }

   /*  get the status code from HTTP headers */
   if (preg_match('/HTTP\/1\.\d+\s+(\d+)/', $response, $matches)) {
      $code = intval($matches[1]);
   } else {
      return false;
   }

   /* see if code indicates success */
   return (($code >= 200) && ($code < 400));
}
// Test & 使用方法:
// var_dump(page_exists('http://tw.yahoo.com'));

