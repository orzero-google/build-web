<?PHP
class s_collect{
	protected $_url;
	protected $_content;
	protected $_status;
	protected $_opt_returntransfer;
	protected $_opt_binarytransfer;
	protected $_opt_userAgent;
	
	public function __construct()
	{
	  $this->_opt_returntransfer = true;
	  $this->_opt_binarytransfer = true;
	  $this->_opt_userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
	}
	
	public function seturl($url)
	{
	  $this->_url = $url;
	}
	
	public function geturl()
	{
	  $s = curl_init($this->_url);
		
		curl_setopt($s, CURLOPT_USERAGENT, $this->_opt_userAgent);
		curl_setopt($s, CURLOPT_RETURNTRANSFER, $this->_opt_returntransfer) ;
		curl_setopt($s, CURLOPT_BINARYTRANSFER, $this->_opt_binarytransfer) ;
		
		// The maximum number of seconds to allow cURL functions to execute. 
    curl_setopt($s,CURLOPT_CONNECTTIMEOUT,60);
    // Tell curl to stop when it encounters an error 
    curl_setopt($s, CURLOPT_FAILONERROR, true);	
    
	  $this->_content = curl_exec($s);
	  $this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);

	  curl_close($s);
	  $s = null;
	}
	
	public function get_content()
	{
	  return $this->_content;
	}
	
	public function get_status()
	{
	  return $this->_status;
	}		
		
	public function get($url){
		$this->seturl($url);
		$this->geturl();

		if($this->get_status() == 200){
			return $this->get_content();
		}else{
			//echo $cc->get_status();
			return false;	
		}			
	}

}

/*
//测试
function debuginfo() {
	global $starttime;
	$mtime = explode(' ', microtime());
	$totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
	echo 'Processed in '.$totaltime.' second(s)';
}

$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];


$cc = new s_collect();

if($page_content = $cc->get('http://www.google.com/') ){
	echo $page_content;	
}else{
	echo $cc->get_status();
}


debuginfo();
*/
?> 