<?php
include_once 'Command.php';

class Tianya{
	var $post;
	var $get;
	
	function get_link($page_content){
		$get['url_area']  = get_mid_content($page_content, '<div class=\'pages\' id="pageDivTop">', '</div>');	
		
		if(empty($get['url_area'])){
			$post['url_area'] = get_mid_content($page_content, '<div id="cttPageDiv"  class="pages">', '</div>');
			if(!empty($post['url_area'])){
				$post['type'] = 'post';
				$post['rs_strTitle_aa'] = strip_tags(get_mid_content($post['url_area'], '<input type="hidden" name="rs_strTitle_aa" value="', '">'));
				$post['intLogo'] = intval(get_mid_content($post['url_area'], '<input type="hidden" name="intLogo" value="', '">'));
				$post['apn'] = get_mid_content($post['url_area'], '<input type="hidden" name="apn" value="', '">');
				unset($post['url_area']);
				$this->post = $post;
				return $post;
			}
		}else{
			$get['type'] = 'get';
			$get['link'] = get_mid_content($get['url_area'], '<input type=\'hidden\' name=\'idArticleslist\' value=\'', ',\'>');
			$get['link_r'] = explode(',', $get['link']);
			unset($get['link']);
			unset($get['url_area']);
			$this->get = $get;
			return $get;
		}
		
		return false;
	}

	function get_info($page_content, $type){
		if($type = 'get'){
			$info_js = get_mid_content($page_content, 
		utf82gbk('<!-- 天涯百宝箱 -->
		<script language="javascript">'),
		utf82gbk('<!-- 天涯百宝箱 -->')
			);
			$info_page['chrType'] = get_mid_content($info_js, 'var chrType = "', '";');
			$info_page['intAuthorId'] = get_mid_content($info_js, 'var intAuthorId = "', '";');
			$info_page['chrAuthorName'] = get_mid_content($info_js, 'var chrAuthorName = "', '";');
			$info_page['chrTitle'] =strip_tags(get_mid_content($info_js, 'var chrTitle = "', '";'));
			$info_page['chrItem'] = get_mid_content($info_js, 'var chrItem = \'', '\';');
			$info_page['intItem'] = get_mid_content($info_js, 'var intItem = \'', '\';');
			$info_page['intArticleId'] = get_mid_content($info_js, 'var intArticleId = "', '";');
			$info_page['firstAuthor'] = get_mid_content($info_js, 'var firstAuthor = \'', '\';');
		}else if($type = 'post'){
			$info_js = get_mid_content($page_content, 
		utf82gbk('<!-- 天涯百宝箱 -->
		<script language="javascript">'),
		utf82gbk('<!-- 天涯百宝箱 -->')
			);
			$info_page['chrType'] = get_mid_content($info_js, 'var chrType = "', '";');
			$info_page['intAuthorId'] = get_mid_content($info_js, 'var intAuthorId = "', '";');
			$info_page['chrAuthorName'] = get_mid_content($info_js, 'var chrAuthorName = "', '";');
			$info_page['chrTitle'] = strip_tags(get_mid_content($info_js, 'var chrTitle = "', '";'));
			$info_page['chrItem'] = get_mid_content($info_js, 'var chrItem = \'', '\';');
			$info_page['intItem'] = get_mid_content($info_js, 'var intItem = \'', '\';');
			$info_page['intArticleId'] = get_mid_content($info_js, 'var intArticleId = "', '";');
			$info_page['firstAuthor'] = get_mid_content($info_js, 'var firstAuthor = \'', '\';');		
		}else{
			return false;
		}
		
		return $info_page;		
	}
}