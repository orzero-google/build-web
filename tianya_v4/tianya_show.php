<?php
include_once './tianya.php';

$fu = '';
$pu = '';
$fv = '';		//base64_encoded
$st = '';		//页面状态：是否固定页面,是否动态


//取得参数
define('IS_GPC', get_magic_quotes_gpc());
foreach(array('_GET','_POST') as $_request) {
	foreach($$_request as $_key => $_value) {
		if ($_key{0} != '_') {
			if (IS_GPC) {
				$_value = s_array($_value);
			}
			$$_key = $_value;
		}
	}
}
if($fu == ''){
	echo '[need:fu]';
	exit;
}else if($pu == ''){
	echo '[need:pu]';
	exit;
}

//$pu = 'http://www.tianya.cn/techforum/content/23/623330.shtml';
//$fv = '{"apn":"7085542,7088802,7091987,7097250,7102285,7111655,7121439,7136146,7154363,7167525,7198866,7225166","intLogo":"0","pID":"5","rs_permission":"1"}';

//print_r($fv);
//echo '<br /><br />';
$fv = json_decode($fv, true);
//print_r($fv);
//echo '<br /><br />';


//print_r(get_tianya($fu, $pu, $fv, $st));
$tianya_page = get_tianya($fu, $pu, $fv, $st);
//print_r($tianya_page);

/**
 * 元素提取
 */
$blog_list = get_content_array($tianya_page[2], $tianya_page[0]);
print_r($blog_list);
