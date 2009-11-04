<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Super AJAX Programming Seed v.1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

<h2>Super AJAX Programming Seed v.1.0</h2>
<p>If you've been thinking about starting to program with AJAX, this is a great place to start. Everything you need is contained in three tiny files. This one, the external javascript file that contains the AJAX functions (ajax.js) and the script page that processes the data. Once you get started playing with this, you'll never stop!</p>
<h4>How does it work?</h4>
<p>AJAX is the method that you can process data dynamically without refreshing a page, basically making a web page nearly as functional as any desktop application. You can to form validation, manipulate database data, whatever!</p>
<p>It works by a few little JavaScript functions that replace the content of an HTML element with the content from another URL. So what you do is pass data from the first page to that other URL through the URL query string, like this: <strong>script_page.php?content=this+is+the+content</strong>. On script_page.php, you can process the data any way you want to, and you just echo the result.</p>
<h4>Some variations on the theme</h4>
<p>Here are some ideas for things you can do to use this technology even more complete:</p>
<ul>
  <li>You can pass additional variables by adjusting the getScriptPage() function on this page to include another variable. Then just add the new variable when you call the script.</li>
  <li>You can add the getScriptPage() function to any of the JavaScript even handlers like onClick or onMouseOver. You can do some fun stuff by experimenting with these different events.</li>
</ul>
</body>
</html>
