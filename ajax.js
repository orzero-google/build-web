
	subject_id = '';
	function handleHttpResponse() {
		if (http.readyState == 4) {
			if (subject_id != '') {
				document.getElementById(subject_id).innerHTML = http.responseText;
			}
		}
	}
	function getHTTPObject() {
		var xmlhttp;
		/*@cc_on
		@if (@_jscript_version >= 5)
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					xmlhttp = false;
				}
			}
		@else
		xmlhttp = false;
		@end @*/
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			try {
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
		return xmlhttp;
	}
	
	function getAJAXObject()
	 {
	 var xmlHttp;
	 
	 try
	    {
	   // Firefox, Opera 8.0+, Safari
	    xmlHttp=new XMLHttpRequest();
	    }
	 catch (e)
	    {
	
	  // Internet Explorer
	   try
	      {
	      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	      }
	   catch (e)
	      {
	
	      try
	         {
	         xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	         }
	      catch (e)
	         {
	         alert("您的浏览器不支持AJAX！");
	         return false;
	         }
	      }
	    }
	  
	  return xmlHttp;
	 }
	
	var http = getAJAXObject(); // We create the HTTP Object