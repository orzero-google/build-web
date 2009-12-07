<?PHP
/*
* @name get_page_content.php
*/
include_once('./curl.get.php');
include_once('./function.php');
include_once('./Snoopy.class.php');

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
//print_r( get_pid_list($page,2) );

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
//print_r( is_tianya_cn_content($page) );

/*
//取得内容
function get_content_array($page_source, $first_second){
	$rq_str_gbk = iconv('UTF-8', 'GBK', '日期：');
	$fw_str_gbk = iconv('UTF-8', 'GBK', '访问：');
	$hfrq_str_gbk = iconv('UTF-8', 'GBK', '回复日期：');
	$to_cut_bf = array('<table', '<TABLE', '<BR><BR>', '<br><br>');
	
	if($first_second == 1){
	    //先粗分,取得段落
	    $content_table = explode('<TABLE cellspacing=0 border=0 bgcolor=', $page_source);
	    //print_r($content_table);
	    $count_table = count($content_table);
	    //当前页面回复序号
	    $cn = 0;
	    foreach($content_table as $content){
	    	if($cn == 0){
	    		$p_content[$cn]['pn'] = '';
	    		$content_tmp = explode('<TD align=center><FONT color=green size=-1>', $content);
	    		$content = $content_tmp[1];
	    	}    	
	    	$cn++;
	    	if($cn == 1){
		    	$p_content[$cn]['author_id'] = '';
		    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');	    		    	
		    	$p_content[$cn]['time'] = $time_cut = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['time'] = get_bf($fw_str_gbk, $p_content[$cn]['time']);
/*		    	if($time_cut1 = explode($fw_str_gbk, $p_content[$cn]['time'])){
		    		$p_content[$cn]['time'] = $time_cut1[0];
		    	}
		    	$content_cut = explode('<div id="tianyaBrandSpan1">', $content);
		    	$p_content[$cn]['content'] = $content_cut[0];
		    	if($content_cut1 = explode('<BR><BR>', $content_cut[0])){
			    	$p_content[$cn]['content'] = $content_cut1[0];
			    }
		    	if($content_cut1 = explode('<br><br>', $content_cut[0])){
			    	$p_content[$cn]['content'] = $content_cut1[0];
			    }	

		    	$p_content[$cn]['content'] = get_mid_content($content,
		    		'<DIV class=content style="WORD-WRAP:break-word;">', 
		    		'<div id="tianyaBrandSpan1">');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
		    	/*
		    	if($content_cut = explode('<TABLE', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	}   
		    	if($content_cut = explode('<BR><BR>', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	}   		    	
		    	if($content_cut = explode('<br><br>', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	} 
	    	}else if($cn == $count_table){
	    		$content_tmp = explode('<!-- google_ad_section_end -->', $content);
	    		$content = $content_tmp[0];	    	
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&vwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&vwriter=', '&idwriter=0&key=0"');
		    	$p_content[$cn]['time'] = get_mid_content($content, $hfrq_str_gbk, '</font>');   
		    	$p_content[$cn]['content'] = get_mid_content($content, '</TR></table>', '</DIV></div>');
				$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
		    	/*
		    	if($content_cut = explode('<BR><BR>', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	}   		    	
		    	if($content_cut = explode('<br><br>', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	} 		   		    			
	    	}else{	    	
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&vwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&vwriter=', '&idwriter=0&key=0"');
		    	$p_content[$cn]['time'] = get_mid_content($content, $hfrq_str_gbk, '</font>');    	
		    	if($content_cut = explode('</center></TD><TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom>&nbsp;</TD></TR></table>', 
		    	$content)){
		    	$p_content[$cn]['content'] = $content_cut[1];
		    	}
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
		    	/*
		    	if($content_cut = explode('<BR><BR>', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	}   		    	
		    	if($content_cut = explode('<br><br>', $p_content[$cn]['content'])){
		    		$p_content[$cn]['content'] = $content_cut[0];
		    	}
	    	}
	    }
	    return $p_content;
/*    
    foreach($content_table as $content){
                   
        if( $cn == 0 ){    //楼贴               
            $p_content[$cn]['writer'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');           
            //如果是第一页,需要二次过滤   
            $info = '';       
            $info = get_mid_content($content, '</a>&nbsp;提交日期：', '</font>');
            $info_cut = '';
            $info_cut = explode(' 访问：', $info);
            if( isset($info_cut[1]) ){
                $p_content[$cn]['time'] = $info_cut[0];
            }else{
                $p_content[$cn]['time'] = $info;
            }
            //如果是第一页,需要二次过滤
            $txt = '';
            $txt = get_mid_content($content, '<DIV class=content style="WORD-WRAP:break-word;">', '<div id="tianyaBrandSpan1"></div>');
            //echo $txt;
            $txt_cut = '';
            $txt_cut = explode('<TABLE cellspacing=0 border=0 ', $txt);
            if( isset($txt_cut[1]) ){
                $p_content[$cn]['txt'] = trim($txt_cut[0]);
            }else{
                $p_content[$cn]['txt'] = trim($txt);
            }           
        }else if( $cn == ($count_table - 1) ){    //尾贴
            $p_content[$cn]['writer'] = get_mid_content($content, 'vwriter=', '&idwriter=');   
            $p_content[$cn]['time'] = get_mid_content($content, '</a>　回复日期：', '</font>');   
            $txt = '';                   
            $txt = get_mid_content( $content, '<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom>&nbsp;</TD></TR></table>', '<!-- google_ad_section_end -->');       
            $txt_cut = '';
            $txt_cut = explode('</DIV></div>', $txt);
            $p_content[$cn]['txt'] = trim($txt_cut[0]);
        }else{
            $p_content[$cn]['writer'] = get_mid_content($content, 'vwriter=', '&idwriter=');   
            $p_content[$cn]['time'] = get_mid_content($content, '</a>　回复日期：', '</font>');           
            $txt = '';
            $txt = explode('<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom>&nbsp;</TD></TR></table>', $content);       
            $p_content[$cn]['txt'] = trim($txt[1]);
        }
        //过滤手机发帖提示
        $mobile_post = '';
        $mobile_post = explode('<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;<a href=', $p_content[$cn]['txt']);
        if( isset($mobile_post[1]) ){
            $p_content[$cn]['txt'] = $mobile_post[0];
        }
       
        $cn++;
    } 
    
    
	}else if($first_second == 2){
    //先粗分,取得段落
    $content_table = explode('<br><TABLE align=center border=0 cellSpacing=0 width=\'100%\'><TR>', $page_source);
    //print_r($content_table);
    $count_table = count($content_table);
    //当前页面回复序号
    $cn = 0;   
    foreach($content_table as $content){   
    	if($cn == 0){
    		$p_content[$cn]['pn'] = get_mid_content($page_source, '<input type="hidden" name="pID" value="', '">');;
    	}else{
	    	$p_content[$cn]['author_id'] = get_mid_content($content, '&vid=', '&idwriter=0&key=0');
	    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');
	    	$p_content[$cn]['time'] = get_mid_content($content, $hfrq_str_gbk, '</font>');
	    	$p_content[$cn]['content'] = trim(get_mid_content($content, '<DIV class=content style="WORD-WRAP:break-word">', '<br></DIV>'));
    	}       
/* v1 :bed !    	     
        if( $cn >= 1 ){    //楼贴               
            $p_content[$cn]['writer'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');           
            //如果是第一页,需要二次过滤   
            $info = '';       
            $info = get_mid_content($content, '</a>&nbsp;提交日期：', '</font>');
            $info_cut = '';
            $info_cut = explode(' 访问：', $info);
            if( isset($info_cut[1]) ){
                $p_content[$cn]['time'] = $info_cut[0];
            }else{
                $p_content[$cn]['time'] = $info;
            }
            //如果是第一页,需要二次过滤
            $txt = '';						  //<DIV class=content style="WORD-WRAP:break-word">            
            $txt = get_mid_content($content, '<DIV class=content style="WORD-WRAP:break-word">', '<div id="tianyaBrandSpan1"></div>');
            $txt_cut = '';
            $txt_cut = explode('<TABLE cellspacing=0 border=0 ', $txt);
            if( isset($txt_cut[1]) ){
                $p_content[$cn]['txt'] = trim($txt_cut[0]);
            }else{
                $p_content[$cn]['txt'] = trim($txt);
            }           
        }else if( $cn == ($count_table - 1) ){    //尾贴
            $p_content[$cn]['writer'] = get_mid_content($content, 'vwriter=', '&idwriter=');   
            $p_content[$cn]['time'] = get_mid_content($content, '</a>　回复日期：', '</font>');   
            $txt = '';       				// <TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom>&nbsp;</TD></TR></table>            
            $txt = get_mid_content( $content, '<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom>&nbsp;</TD></TR></table>', '<!-- google_ad_section_end -->');       
            $txt_cut = '';
            $txt_cut = explode('</DIV></div>', $txt);
            $p_content[$cn]['txt'] = trim($txt_cut[0]);
        }else{
            $p_content[$cn]['writer'] = get_mid_content($content, 'vwriter=', '&idwriter=');   
            $p_content[$cn]['time'] = get_mid_content($content, '</a>　回复日期：', '</font>');           
            $txt = '';
            $txt = explode('<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom>&nbsp;</TD></TR></table>', $content);       
            $p_content[$cn]['txt'] = trim($txt[1]);            
        }
        //过滤手机发帖提示
        $mobile_post = '';
        $mobile_post = explode('<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;<a href=', $p_content[$cn]['txt']);
        if( isset($mobile_post[1]) ){
            $p_content[$cn]['txt'] = $mobile_post[0];
        }
v1 end       
        $cn++;    	     
    }       
    return $p_content;		
	}
}
*/
//print_r( get_content_array($page) );

//$page = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
//$page = $collect->get('http://www.tianya.cn/techforum/content/213/3072.shtml');
//构造网页
/*
//副版表单
apn	101260,110324,124881
intLogo	0
pID	2
rs_permission	1
*/

/*
//第二版,取得内容
function get_content_array($page_source, $first_second){
	$rq_str_gbk = iconv('UTF-8', 'GBK', '日期：');
	$fw_str_gbk = iconv('UTF-8', 'GBK', '访问：');
	$to_cut_bf = array('<table', '<TABLE', '<BR><BR>', '<br><br>', '<font', '<FONT');
	
	if($first_second == 1){
		$page_source = get_mid_content($page_source, '<TABLE id="firstAuthor"', '</DIV></div>');
		$table_cut = explode('<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom></TD>', $page_source);
		$cn = 0;
		
		foreach($table_cut as $content){
			if($cn == 0){
		    	$p_content[$cn]['author_id'] = '';
		    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['time'] = get_bf($fw_str_gbk, $p_content[$cn]['time']); //首页需二次过滤
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<div id="pContentDiv"><DIV class=content style="WORD-WRAP:break-word;">',
		    	'<div id="tianyaBrandSpan1">');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
			}else{
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&vwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&vwriter=', '&idwriter');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'</TD></TR></table>',
		    	'<TABLE cellspacing=0 border=0 bgcolor=');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);			
			}
			$cn++;
		}
		return $p_content;
	}else if($first_second == 2){
		//echo $page_source;
		$page_source = get_mid_content($page_source, 
		'<div id="pContentDiv"><',
		'<div id="cttPageDiv1"');
		$table_cut = explode('<TABLE align=center border=0 cellSpacing=0 width=\'100%\'><TR>', $page_source);
		$cn = 0;
		
		foreach($table_cut as $content){
			if($cn == 0){
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&idwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<DIV class=content style="WORD-WRAP:break-word">',
		    	'<div id="tianyaBrandSpan1"></div></DIV>');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
			}else{
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&vwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<DIV class=content style="WORD-WRAP:break-word">',
		    	'</DIV>');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);			
			}
			$cn++;
		}
		return $p_content;		
	}
}
*/
//第三版,取得内容
function get_content_array($page_source, $first_second){
	$rq_str_gbk = iconv('UTF-8', 'GBK', '日期：');
	$fw_str_gbk = iconv('UTF-8', 'GBK', '访问：');
	$to_cut_bf = array('<table', '<TABLE', '<BR><BR>', '<br><br>', '<font', '<FONT');
	
	
	if($first_second == 1){
		$page_source = get_mid_content($page_source, '<TABLE id="firstAuthor"', '<br></DIV></div>');
		$table_cut = explode('<TD WIDTH=100 ALIGN=RIGHT VALIGN=bottom></TD>', $page_source);
		$cn = 0;
		
		foreach($table_cut as $content){
			if($cn == 0){
		    	$p_content[$cn]['author_id'] = '';
		    	$p_content[$cn]['author'] = get_mid_content($content, '&idwriter=0&key=0 target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['time'] = get_bf($fw_str_gbk, $p_content[$cn]['time']); //首页需二次过滤
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<div id="pContentDiv"><DIV class=content style="WORD-WRAP:break-word;">',
		    	'<div id="tianyaBrandSpan1">');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
			}else{
		    	$p_content[$cn]['author_id'] = get_mid_content($content, 'vid=', '&vwriter=');
		    	$p_content[$cn]['author'] = get_mid_content($content, '&vwriter=', '&idwriter');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'</TD></TR></table>',
		    	'<TABLE cellspacing=0 border=0 bgcolor=');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);			
			}
			$cn++;
		}
		return $p_content;
	}else if($first_second == 2){
		//echo $page_source;
		$page_source = get_mid_content($page_source, 
		'<div id="pContentDiv"><',
		'<div id="cttPageDiv1"');
		$table_cut = explode('<TABLE align=center border=0 cellSpacing=0 width=\'100%\'><TR>', $page_source);
		$cn = 0;
		
		foreach($table_cut as $content){
			if($cn == 0){
		    	$p_content[$cn]['author_id'] = get_mid_content($content, '<a href=http://my.tianya.cn/', ' target=_blank>');
		    	$p_content[$cn]['author'] = get_mid_content($content, ' target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<DIV class=content style="WORD-WRAP:break-word">',
		    	'<div id="tianyaBrandSpan1"></div></DIV>');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);
			}else{
		    	$p_content[$cn]['author_id'] = get_mid_content($content, '<a href=http://my.tianya.cn/', ' target=_blank>');
		    	$p_content[$cn]['author'] = get_mid_content($content, ' target=_blank>', '</a>');
		    	$p_content[$cn]['time'] = get_mid_content($content, $rq_str_gbk, '</font>');
		    	$p_content[$cn]['content'] = get_mid_content($content, 
		    	'<DIV class=content style="WORD-WRAP:break-word">',
		    	'</DIV>');
		    	$p_content[$cn]['content'] = get_bf($to_cut_bf, $p_content[$cn]['content']);			
			}
			$cn++;
		}
		return $p_content;		
	}
}

function create_url($pid_list_r, $is_tianya_r){
	$channel = $is_tianya_r[1];
	if($is_tianya_r[0] == 1){
		foreach($pid_list_r as $articleid){
			$url[] = 'http://www.tianya.cn/publicforum/content/'.$channel.'/1/'.$articleid.'.shtml';
		}
    return $url;
  }else if($is_tianya_r[0] == 2){
		foreach($pid_list_r as $articleid){
			$url = 'http://www.tianya.cn/techforum/content/'.$is_tianya_r[1].'/'.$is_tianya_r[4].'.shtml';
		}
    return $url;
  }
  return false;   
}

