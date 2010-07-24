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
		'success' => 'js:showinfo', // javascript function to call on success
		'error' => 'js:error',
		'data' => 'js:\'ajax=\'+$(\'#url\').val()', // The $_GET data (parameters) to pass
		'beforeSend' => 'js:beforeSend',
	),
	array( // The htmlOptions for the anchor tag
		'name' => 'surl',
		'id' => 'surl',
	)
);

echo CHtml::button(
	'整理',
	array( // The htmlOptions for the anchor tag
		'name' => 'gurl',
		'id' => 'gurl',
		'style' => 'display:none;',
		'onclick' =>'collation();',
	)
);

?>
	</div>
</div>
<div id="info"></div>
<div id="ret" style="display:none;">
	<div class="gridtile" id="furl"></div>
	<div class="gridtile" id="channel_cn"></div>
	<div class="gridtile" id="title"></div>
	<div class="gridtile" id="author_name"></div>	
	<div class="gridtile" id="pcount"></div>
	<div class="gridtile" id="pid"></div>
</div>

<?php 
echo CHtml::scriptFile('/js/tianya.js'); 
echo CHtml::cssFile('/css/tianya.css'); 
?>
