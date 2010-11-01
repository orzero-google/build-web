<?php
$xml_template = '
<response-list>
   <response ID="1287105144">
      <operation name="admin::sslvpn::get_sslvpn_cfg"/>
      <ErrorCode value="0x00000000"/>
      <ErrorString value=" No Error Happened!"/>
      <outputs>
         <item name="status" value="1"/>
         <item name="interface" value="any"/>
         <item name="permitip">
            <item subnet="172.17.0.1/16"/>
         </item>
         <item name="permitipv6">
            <item subnet="172.17.0.1/16"/>
         </item>        
      </outputs>
   </response>
</response-list>
		';

		$xml_template = '
<request-list>
   <virtual id="0"/>
   <loginUser name="admin@'.$_SESSION["sessionid"].'"/>
   <source from="WEB"/>
   <language value="EN"/>
   <request ID="'.time().'">
      <operation name="module"/>
   </request>
</request-list>
';
$xml_template = '		
<request-list>
  <virtual id = "0"/>
  <loginUser name= "admin@2097192"/>
  <source from="WEB"/>
  <language value="EN"/>
  <request ID = "1286956345">
  <operation name= "LICENSE::license_info::getLicenseInfo"/>
  <request_get_count value="0" max=""/>
  <params>
   <item name ="get_count" value="-1">
   max
   </item>
   <item name ="id" />
   <item name ="name" />
   <item name ="import_time" />
   <item name ="sequence" />
   <item name ="total_time" />
   <item name ="status" />
   <item name ="ext" />
  </params>
 </request>
</request-list>';

$xml_template = '<response-list>
   <response ID="1287465333">
      <operation name="systemsetting::other::get_others"/>
      <ErrorCode value="0x00000000"/>
      <ErrorString value="OK"/>
      <outputs>
         <item name="ext1" value="00"/>
         <item name="ext1" value="11"/>
         <item name="ext1" value="22"/>
      </outputs>
   </response>
</response-list>';

$xml_template = '<request-list>
   <virtual id="0"/>
   <loginUser name="admin@2097153"/>
   <source from="shell"/>
   <language value="EN"/>
   <request ID="exe-0x374f17a8">
      <operation name="admin::sslvpn::modify_sslvpn_cfg"/>
      <params>
         <item name="status" value="1"/>
         <item name="interface" value="ge0/1"/>
         <item name="permitip">
            <item subnet="172.17.0.1/16"/>
            <item subnet="172.18.0.1/16"/>
         </item>
         <item name="permitipv6">
            <item subnet="64::/48"/>
            <item subnet="65::/48"/>
         </item>
      </params>
   </request>
</request-list>';

$xml_template =
'<?xml version="1.0" encoding="UTF-8" standalone="no"?>

<response-list>
   <response ID="1287465333">
      <operation name="systemsetting::other::get_others"/>
      <ErrorCode value="0x00000000"/>
      <ErrorString value="OK"/>
      <outputs>
         <item name="ext1" value="3:49"/>
      </outputs>
   </response>
</response-list>';

function ToArray ( $data )
{
  if (is_object($data)) $data = get_object_vars($data);
  return (is_array($data)) ? array_map(__FUNCTION__,$data) : $data;
}

    function array2Dom($arr, &$dom, &$parent) {
        if (is_array($arr)) {
            $domNode=null;
            foreach($arr as $key => $value) {
                if (strpos($key, "@") === 0 && !is_array($value)) {
                    $parent->setAttribute(substr($key,1), $value);
                } else {
                    $key = preg_match("#^[0-9]+$#", $key) ? "entry": $key;
                    $domNode = $dom->createElement($key);
                    if (is_array($value)) {
                        array2Dom($value, $dom, $domNode);
                    } else {
                        $domNode->nodeValue = $value;
                    }
                    $parent->appendChild($domNode);
                }
            }
            return $domNode;
        }
    } 

define(LF, "\r\n");
function array2xml($array, $name='array', $standalone=TRUE, $beginning=TRUE) {

  global $nested;

  if ($beginning) {
    if ($standalone) header("content-type:text/xml;charset=utf-8");
    $output .= '<'.'?'.'xml version="1.0" encoding="UTF-8"'.'?'.'>' . LF;
    $output .= '<' . $name . '>' . LF;
    $nested = 0;
  }
 
  // This is required because XML standards do not allow a tag to start with a number or symbol, you can change this value to whatever you like:
  $ArrayNumberPrefix = 'ARRAY_NUMBER_';
 
   foreach ($array as $root=>$child) {
    if (is_array($child)) {
      $output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>' . LF;
      $nested++;
      $output .= array2xml($child,NULL,NULL,FALSE);
      $nested--;
      $output .= str_repeat(" ", (2 * $nested)) . '  </' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>' . LF;
    }
    else {
      $output .= str_repeat(" ", (2 * $nested)) . '  <' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '><![CDATA[' . $child . ']]></' . (is_string($root) ? $root : $ArrayNumberPrefix . $root) . '>' . LF;
    }
  }
 
  if ($beginning) $output .= '</' . $name . '>';
 
  return $output;
}

$_xml = '';
function O2_array2xml($array, &$_xml)
{
	global $_tkey;
	$_start = '<';
	$_end   = '>';
	$_blank = ' ';
	$_lf    = "\r\n";
	
	//print_r($array);
	if (is_array($array)) {
		foreach ($array as $k=>$v ) {
			if (is_int($k)) {
				//echo $_tkey.$k.'|';
				//print_r($v);
				//多子项处理
				O2_array2xml(array($_tkey => $v), &$_xml);
				//$this->_tkey = '';
				continue;
			} else {
				//跳过多子项父key
				if (!empty($v[0])) {
					
					$_tkey = $k;
					//echo $k.'|';					
					O2_array2xml($v, &$_xml);
					continue;
				}
				//print_r($v);
				$_xml .= $_start.$k;
				
				//设置项属性值
				if (is_array($v['@attributes']) && !empty($v['@attributes'])) {				
					foreach ($v['@attributes'] as $vk => $vv) {
						$_xml .= $_blank.$vk.'="'.$vv.'"';
					}
					unset($v['@attributes']);
				}
				
				//递归
				if (empty($v)) {
					$_xml .= $_blank.'/'.$_end.$_lf;
				} else {
					$_xml .= $_end.$_lf;
					O2_array2xml($v, &$_xml);
					$_xml .= $_start.'/'.$k.$_end.$_lf;
				}
			}
		}
	} 
}

$xml = simplexml_load_string($xml_template);
//$array = ToArray($xml);
//print_r(ToArray($xml));
//print_r($xml->asXML());
//$xml->virtual &= simplexml_load_string($xml_template);
//print_r($xml->asXML());
$a = ToArray($xml);
//unset($a[response][outputs][item][1]);
print_r($a);

O2_array2xml(array($xml->getName() => $a), &$_xml);
print_r($_xml);

//$xml_new = simplexml_load_string($_xml);
//print_r($xml_new->asXML());

/*
$p = '
<root >
<virtual id="0" />
<loginUser name="admin@2097192" />
<source from="WEB" />
<language value="EN" />
<request ID="1286956345" >
<operation name="LICENSE::license_info::getLicenseInfo" />
<request_get_count value="0" max="" />
<params >
<item >
<aa name="get_count" value="-1" />
<bb name="id" />
<cc name="name" />
<dd name="import_time" />
<ee name="sequence" />
<ff name="total_time" />
<gg name="status" />
<hh name="ext" />
</item>
</params>
</request>
</root>
';
$xml_p = simplexml_load_string($p);
print_r($xml_p->asXML());
*/

?> 