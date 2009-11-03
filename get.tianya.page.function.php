<?PHP
/*
* @name get_page_content.php
*/
include_once('./curl.get.php');
include_once('./function.php');

$collect = new s_collect();
$page = $collect->get('http://www.tianya.cn/publicforum/content/free/1/1532694.shtml');
//echo $page;
echo '<pre>';

//判断是否是天涯的内容帖子,是则返回:(1,频道缩写,名称)
function is_tianya_cn_content($page_source){
    $content_flag = get_mid_content_array($page_source, '<span class="lb12">', '</span>');
    //print_r( $content_flag );   
    $channel = get_mid_content($page_source, 'var strItem="', '";');
    //echo $channel;   
    if( (count($content_flag) == 3) && ($content_flag[0][0] == 0) && ($content_flag[1][0] == 1) && ($content_flag[2][0] == 1) ){
        if( isset($channel) ){
            return array(1, $channel, $content_flag[2][1]);   
        }
    }
        return false;   
}
//print_r( is_tianya_cn_content($page) );



//取得导航部分
function get_pid_list($page_source){
    $nav = get_mid_content($page_source, '<!-- google_ad_section_start -->', '<table border="0" align="center" cellspacing="0" width="100%">');
   
    if($nav == null){        //只有首页
        return false;   
    }
    $pid_list_str = get_mid_content($nav, '<input type=\'hidden\' name=\'idArticleslist\' value=\'', ',\'>');
    $pid_list_array = explode(',', $pid_list_str);
    //print_r( $pid_list_array );
    return $pid_list_array;
}
//
print_r( get_pid_list($page) );


//取得内容
function get_content_array($page_source){
    //先粗分,取得段落
    $content_table = explode("\n\r".'<TABLE cellspacing=0 border=0 bgcolor=', $page_source);
    //print_r($content_table);
    $count_table = count($content_table);
    //当前页面回复序号
    $cn = 0;   
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
       
    return $p_content;
}
//print_r( get_content_array($page) );


//构造网页
function create_url($articleid_r){
   
}

?>