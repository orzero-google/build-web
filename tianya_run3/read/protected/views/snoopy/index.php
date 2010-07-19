
<div class="form">
	<div class="row">
	
<?php echo CHtml::textField('url', '', array('size'=>'80'));?>
<?php echo CHtml::ajaxButton(
	'click',
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

?>
	</div>
</div>
<div id="info"></div>
<tr>
	<div class="gridtile">
	作者
	</div>
</tr>
<tr>
	<div class="gridtile">
	作者
	</div>
</tr>
<td>
	<div class="gridtile">
	作者
	</div>
</td>


<?php 
echo CHtml::script(
'function success(data){
	$("#info").html(String(data));
	return $("#surl")[0].disabled = false;
}
function geturl(){
	return $("#surl").val();
}
function beforeSend(){
	return $("#surl")[0].disabled = true;
}'
); 
echo CHtml::css(
'div.gridtile  {
#float:left;
margin:2px;
width:10em;
border:2px solid #C3D9FF;
}'
); 

?>