<?php
	// You can do anything with the data. Just think of the possibilities!
	
	$strlen = strlen($_GET['content']);
	$low_string = strtolower($_GET['content']);
	if (strpos($low_string,'ajax') > -1) {
		$is_ajax = 'Yes';
	} else {
		$is_ajax = 'No';
	}
	echo '
		<p>Typed content: <strong>' . $_GET['content'] . '</strong></p>
		<p>Number of characters: <strong>' . $strlen . '</strong></p>
		<p>String contains the word "AJAX": <strong>' . $is_ajax . '</strong></p>
	';
?>