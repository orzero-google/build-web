<?php
/**
 * @author LJ
 * @date Oct 13, 2010
 */
class O2XMLIO{
	var $param_in  = array();
	var $param_out = array();
		
	var $xml_in  = '';			//请求xml路径
	var $xml_out = '';			//应答xml路径
	
	var $module  = '';			//模块名称
	var $xml_template = '';
	
	//用数组构造$xml
	var $_tkey  = '';
	var $_start = '<';
	var $_end   = '>';
	var $_blank = ' ';
	var $_lf    = "\r\n";
	
	function O2XMLIO($module){
		$this->_start = '<';
		$this->_end   = '>';
		$this->_blank = ' ';
		$this->_lf    = "\r\n";
		
		$time = time();
		$this->module = $module;
		$this->xml_in = 'sendxml/__'.str_replace(':', '_', $module).'_'.$time.'.xml';
		$this->xml_template = 
'<request-list>
   <virtual id="0"/>
   <loginUser name="admin@'.$_SESSION["sessionid"].'"/>
   <source from="WEB"/>
   <language value="EN"/>
   <request ID="'.$time.'">
      <operation name="'.$this->module.'"/>
      <params/>
   </request>
</request-list>';
	}
	
/**
 * 传入数组格式实例
 ***********************************
 *[item] => Array
 *(
 *	[0] => Array
 *	(
 *		[@attributes] => Array
 *		(
 *			[name] => ext1
 *			[value] => 00
 *		)
 *	)
 *	[2] => Array
 *	(
 *		[@attributes] => Array
 *		(
 *			[name] => ext1
 *			[value] => 22
 *		)
 *	)
 *)
 ***********************************
 */
	function set_xml_in($param_in)
	{
		$this->param_in = $param_in;
		if ($xml_obj = simplexml_load_string($this->xml_template)) {
			$xml_name = $xml_obj->getName();
			$xml_arr = $this->object_to_array(array($xml_name => $xml_obj));
		}		
		
		
		if (is_array($this->param_in) && !empty($this->param_in)) {
			$xml_arr[$xml_name]['request']['params'] = $this->param_in;
			$this->_array2xml($xml_arr);
			if (!empty($this->xml)) {
				if (file_put_contents($this->xml_in, $this->xml)) {
					return true;
				}
			}
		}

		return false;
	}
	
	function get_xml_out()
	{
		if( !empty($this->xml_in) ) {
			$this->xml_out = msg_send_retfile( $this->xml_in );
			unlink($this->xml_in);
			$this->xml_in = '';
			return true;
		} else {
			return false;
		}
	}
	
	function get_param_out()
	{
		$this->param_out = '';
		if ( file_exists( $this->xml_out ) ) {
			if ($xml_obj = simplexml_load_file($this->xml_out)) {
				$this->param_out = $this->object_to_array($xml_obj);
				unlink( $this->xml_out );
			}
		}
		
		if (empty($this->param_out)) {
			return false;
		} else {
			return $this->param_out;
		}		
	}


	function _array2xml($array)
	{
		if (is_array($array)) {
			foreach ($array as $k=>$v ) {
				if (is_int($k)) {
					$this->_array2xml(array($this->_tkey => $v));
					continue;
				} else {
					//设置多子项父名
					if (!empty($v[0])) {
						$this->_tkey = $k;
						$this->_array2xml($v);
						continue;
					}
					
					$this->xml .= $this->_start.$k;					
					//设置项属性值
					if (is_array($v['@attributes']) && !empty($v['@attributes'])) {				
						foreach ($v['@attributes'] as $vk => $vv) {
							$this->xml .= $this->_blank.$vk.'="'.$vv.'"';
						}
						unset($v['@attributes']);
					}
					
					//递归子项
					if (empty($v)) {
						$this->xml .= $this->_blank.'/'.$this->_end.$this->_lf;
					} else {
						$this->xml .= $this->_end.$this->_lf;
						$this->_array2xml($v);
						$this->xml .= $this->_start.'/'.$k.$this->_end.$this->_lf;
					}
				}
			}
		}
	}
	
	function object_to_array($obj) {
	        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
	        foreach ($_arr as $key => $val) {
	                $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val;
	                $arr[$key] = $val;
	        }
	        return $arr;
	}
}