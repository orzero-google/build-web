
<div class="form">
	<div class="row">
<?php echo CHtml::ajaxButton(
	'click',
	'index.php?r=snoopy',
	array( // The ajaxOptions (jQuery stuff)
		'dataType' => 'json', // Page will output json to parse
		'success' => 'js:handeSuccess', // javascript function to call on success
		'data' => 'js:handeGeturl', // The $_GET data (parameters) to pass
	),
	array( // The htmlOptions for the anchor tag
		//'href' => '/site/updatePost' // This is what the href of the anchor will be, defaults to #
		// ^^ that's the new option I found out about, I didn't know it worked that way...
	)
);
?>
	</div>
</div>

<?php echo CHtml::scriptFile('index.php?r=snoopy/js'); ?>