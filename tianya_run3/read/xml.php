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
         <item name="permitipv6"/>
      </outputs>
   </response>
</response-list>
		';
function ToArray ( $data )
{
  if (is_object($data)) $data = get_object_vars($data);
  return (is_array($data)) ? array_map(__FUNCTION__,$data) : $data;
}



echo '<pre>';
$xml = simplexml_load_string($xml_template);
$outputs = $xml->xpath('response/outputs');
foreach($xml->response->outputs->children() as $key => $val){
	echo $key .'=>'. $val;
	//echo '<br />';
	$t = $val->children();
	if ( !empty($t) ) {
		@print_r($t->children());
	}
}
//print_r($outputs);
//print_r($outputs[0]->xpath('item'));

?> 