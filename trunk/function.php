<?php

//ȡ���м��ַ���
function get_mid_content($str, $startmark, $endmark){
	//c1 c2[mark:end]c3
	$temp1 = explode($startmark, $str, 2);
	
	//�Ƿ��ҵ�ǰ���ַ�
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


//ȡ���м��ַ����б�
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
	
	//array(�Ƿ��ҵ�������,��Ҫ���ֶ�);
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

?>