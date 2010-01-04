<?php

//$compressed = base64_encode('Compress me');
//echo $compressed;

//echo strlen('tianya/67e5b36192a11a87fd2f94a8ddbe52da/54b4111670cacc38f8b1e61b6eb8a687.php');

//把url作为参数传入,如果是本地链接则返回补齐的链接
function local_url($url){
	global $dii_dir_path;
	if($url != ''){
		$cut_url = explode('site/', $url, 2);
		if(isset($cut_url[1])){
			if($cut_url[0] == '' || $cut_url[0] == '/'){
				$local_url = $dii_dir_path['domain_url'].'/site/'.$cut_url[1];
				return $local_url;
			}
		}
	}
	
	return $url;
}