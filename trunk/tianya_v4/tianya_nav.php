<?php
/**
 * 先判断页面类型，主版还是副版
 * 接着提取导航数据
 */
include_once './GetPg.class.php';
include_once './function.base.php';

//判断是否是天涯的内容帖子,同时返回：
//是主版则返回:(1,频道英文缩写,频道中文名称,标题,当前页id)
//是副版则返回:(2,频道英文缩写,频道中文名称,标题,当前页id)
function is_tianya_cn_content($page_source){
 		//主版
    $channel = get_mid_content($page_source, 'var strItem="', '";');
    if($channel != null){
	    $content_flag = get_mid_content_array($page_source, '<span class="lb12">', '</span>');
	    //print_r( $content_flag );      
	    $forum_name = get_mid_content($page_source, '" class="lb12">', '</a>');
	    //$article_name = Snoopy::_striptext(get_mid_content($page_source, 'var chrTitle = "', '";'));
	    $article_name_cut = get_mid_content($page_source, 'var chrTitle = "', '";');
	    //echo $article_name_cut;
	    $article_name = preg_replace("'<[^<>]*>'i", '', $article_name_cut);
	    //echo $article_name;
	    //echo $article_name;
	    $article_id = get_mid_content($page_source, 'var idArticle="', '";');
	    //echo $channel;   
	    if( (count($content_flag) == 3) && ($content_flag[0][0] == 0) && ($content_flag[1][0] == 1) && ($content_flag[2][0] == 1) ){
	        if( isset($channel) ){
	            //return array('first_second'=>1, 'channel'=>$channel, 'form_name'=>$forum_name); 
	            //echo '<pre>';
	            //print_r( array(1, $channel, $forum_name, $article_name, $article_id) );
	            return array(1, $channel, $forum_name, $article_name, $article_id); 
	        }
	    }
	  }
		//副版
    $channel = get_mid_content($page_source, 'var idItem="', '";');
    if($channel != null){
    	$content_flag = '';
	    $content_flag = get_mid_content_array($page_source, '<span class="lb12">', '</span>');
	    //print_r( $content_flag ); 
	    $forum_name = '';
	    $forum_name = get_mid_content($page_source, '" class="lb12">', '</a>');
	    $article_name = get_mid_content($page_source, 'var chrTitle = "', '";');
	    $article_name = preg_replace("'<[^<>]*>'i", '', $article_name);
	    $article_id = get_mid_content($page_source, 'var idArticle="', '";');
	    //echo $channel;   
	    if( (count($content_flag) == 3) && ($content_flag[0][0] == 0) && ($content_flag[1][0] == 1) && ($content_flag[2][0] == 1) ){
	        if( isset($channel) ){
	            //return array('first_second'=>2, 'channel'=>$channel, 'form_name'=>$forum_name);  
	            return array(2, $channel, $forum_name, $article_name, $article_id);
	        }
	    }
	  }
	  
        return false;   
}

$url = '';
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

if($url != ''){
	$page_obj = new get_url_cache($url);
	$page_obj->getURL();
	$content = $page_obj->getContent();
	print_r(is_tianya_cn_content($content));
}else{
	echo '[need:url]';
}

