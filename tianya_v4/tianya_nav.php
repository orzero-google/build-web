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
//取得导航部分
function get_pid_list($page_source, $first_second){
	if($first_second == 1){
    $nav = get_mid_content($page_source, '<!-- google_ad_section_start -->', '<table border="0" align="center" cellspacing="0" width="100%">');   
    if($nav == null){        //只有首页
        return false;   
    }
    $pid_list_str = get_mid_content($nav, '<input type=\'hidden\' name=\'idArticleslist\' value=\'', ',\'>');
    $pid_list_array = explode(',', $pid_list_str);
    //print_r( $pid_list_array );
    
	if($pid_list_array[0] == null){
		$pid_list_array[0] = get_mid_content($page_source, 'var idArticle="', '";');
	}	    
    return $pid_list_array;
  }else if($first_second == 2){
  	$pid_list_str = get_mid_content($page_source, '<input type="hidden" name="apn" value="', '">');
  	$pid_list_array = explode(',', $pid_list_str);
  	return $pid_list_array;
  }
  return false;
}

//创建连接
function mk_link_list($url, $is_tianya, $pid_list){
	$pid_str = implode(',', $pid_list);
	if($is_tianya[0] == 1){

	}else if($is_tianya[0] == 2){
 		
  		$i = 0;
  		$get = array();
  		foreach($pid_list as $pid){
  			$get[$i]['fu'] = $get[$i]['pu'] = $url;
  			$get[$i]['fv'] = '{"apn":"'.$pid_str.'","intLogo":"0","pID":"'.$i++.'","rs_permission":"1"}';
  			$get[$i]['st'] = true;
  			$i++;
  		}	
  		$get[($i -1)]['st'] = false;
  		return $get;
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
	$nav = is_tianya_cn_content($content);
	print_r($nav);
	
	$pid = get_pid_list($content, $nav[0]);
	print_r($pid);
	
	$link = mk_link_list($url, $nav, $pid);
	print_r($link);
	
}else{
	echo '[need:url]';
}

