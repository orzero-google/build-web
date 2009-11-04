<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Super AJAX Programming Seed v.1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">

		function getScriptPage(div_id,content_id) {
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.onreadystatechange = handleHttpResponse;
			http.open("GET", "script_page.php?content=" + escape(content), true);
			
			http.send(null);
		}	

</script>
<link href="styles.css" rel="stylesheet" type="text/css"></link>	
</head>

<body>
<div class="ajax-div">
	<div class="input-div">
	Enter the text you want to appear:
	<input type="text" onKeyUp="getScriptPage('output_div','text_content')" id="text_content" size="40">
	</div>
	<div class="output-div-container">
	
	<div id="output_div">Original contents</div>
	</div>
</div>

</body>
</html>
