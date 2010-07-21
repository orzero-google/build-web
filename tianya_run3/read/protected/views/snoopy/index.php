
<div class="form">
	<div class="row">	
<?php
echo CHtml::textField('url', '', array('size'=>'80'));
echo CHtml::ajaxButton(
	'分析',
	'index.php?r=snoopy',
	array( // The ajaxOptions (jQuery stuff)
		'type' => 'post',
		'dataType' => 'json', // Page will output json to parse
		'success' => 'js:success', // javascript function to call on success
		'data' => 'js:\'ajax=\'+$(\'#url\').val()', // The $_GET data (parameters) to pass
		'beforeSend' => 'js:beforeSend',
	),
	array( // The htmlOptions for the anchor tag
		'name' => 'surl',
		'id' => 'surl',
	)
);

echo CHtml::ajaxButton(
	'整理',
	'index.php?r=snoopy/save',
	array( // The ajaxOptions (jQuery stuff)
		'type' => 'post',
		'dataType' => 'json', // Page will output json to parse
		'success' => 'js:success', // javascript function to call on success
		'data' => 'js:\'ajax=\'+$(\'#url\').val()', // The $_GET data (parameters) to pass
		'beforeSend' => 'js:beforeSend',
	),
	array( // The htmlOptions for the anchor tag
		'name' => 'gurl',
		'id' => 'gurl',
		'style' => 'display:none;',
	)
);

?>
	</div>
</div>
<div id="info"></div>
<div id="ret" style="display:none;">
	<div class="gridtile" id="channel_cn"></div>
	<div class="gridtile" id="title"></div>
	<div class="gridtile" id="author_name"></div>
	<div class="gridtile" id="pcount"></div>
	<div class="gridtile" id="furl"></div>
</div>

<?php 
echo CHtml::script(
'function success(data){
	//$("#info").html(String(data));
	$("#channel_cn").html(\'<span class="title">频道: </span>\' + data.channel_cn);
	$("#title").html(\'<span class="title">标题: </span>\' + data.title);
	$("#author_name").html(\'<span class="title">作者: </span>\' + data.author_name);
	$("#pcount").html(\'<span class="title">页数: </span>\' + data.pcount);
	$("#furl").html(\'<span class="title">首页: </span>\' + \'<a href="\' + data.furl + \'">\' + data.furl + \'</a>\');
	$("#ret").show();
	$("#gurl").show();
	
	return $("#surl")[0].display = none;
}
function geturl(){
	return $("#surl").val();
}
function beforeSend(){
	return $("#surl")[0].disabled = true;
}'
); 
echo CHtml::css(
'div.gridtile{
float:left;
margin:4px;
border:1px solid #C3D9FF;
color:#6688CC;
display:block;
height:19px;
padding:2px 4px 0 4px;
text-decoration:none;
font-family:arial,sans-serif;
text-align:center;
font-size:14px;
#font-weight:bold;
clear:both;
}
span.title{
color:green;
}'
); 

?>
