<?php
include_once 'Command.php';

function get_link($page_content){
	$post['url'] = get_mid_content($page_content, '<div id="cttPageDiv"  class="pages">', '</div>');
	$get['url']  = get_mid_content($page_content, '<div class=\'pages\' id="pageDivTop">', '</div>');
	
	
	
	
}