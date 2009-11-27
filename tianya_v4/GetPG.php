<?php 
/*
+-------------------------------------------------------------------------------+
| @description	:	通过curl函数实现远程页面的获取,并存储
| @parameter	:	$url,$cacheFile
| @export 		:	[页面内容,缓存地址]或[错误号]([content,route|errid])
| @date 		:	2009/11/19
| @author 		:	wutou<:>orzero.com
| @version 		:	0.1
+-------------------------------------------------------------------------------+
*/

//abstract 抽象类或者方法,必须被继承后使用
//final 禁止被继承和覆盖
//static 静态类,可以在不实例化的情况下直接呼叫方法
//instanceof 测试是否派生或实例与某个类
/*
<?php
class baseClass { }

$a = new baseClass;

if ($a instanceof baseClass) {
   echo "Hello World";
}
?>
*/

//__autoload()自动执行
/*
<?php
function __autoload($className) {
   include_once $className . ".php";
}

$object = new ClassName;
?>
*/

//接口:
/*
interface ThrowableA {
   public function getMessage();
}
interface ThrowableB {
   public function getMessage();
}
class MyException implements ThrowableA,ThrowableB {
   public function getMessage() {
       // ...
   }
}
*/

//__call, __get() and __set():方法呼叫和属性访问
include_once 'Snoopy.class.php';

class get_from_url_cache{	
	
	//构造函数
	public function __construct($Url, $File, $submit_vars='')
	{	
		if($this->is_url($Url)){
			$this->Url = $Url;
		}else{
			if($this->_show_log) echo 'false: $this->is_url('.$Url.')<br />';	
			return false;
		}
		
		if($submit_vars != ''){
			if(is_array($submit_vars)){
				$this->submit_vars = $submit_vars;
			}else{
				if($this->_show_log) echo 'false: is_array('.$submit_vars.')<br />';	
				return false;
			}
		}else{
			$this->submit_vars = '';
		}
		
		$File = str_replace('\\','/', $File);
		$File = preg_replace('/\/+/is','/', $File);
		$File = str_replace('//','/', $File);		
		if(!preg_match ("/[^\w\-\.\/\\\\@\#\%\&\*\(\)\+\?]+/i", $File)){
			$this->File = $File;
		}else{
			if($this->_show_log) echo '(preg_match ("/[^\w\-\.\/\\\\@\#\%\&\*\(\)\+\?]+/i", '.$File.')<br />';
			return false;
		}
		
		$this->time = time();		
		$this->content = '';	
		
		if($this->_show_log){
			echo 'true:new get_from_url_cache();<br />';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;'.'$Url:'.$Url.'<br />';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;'.'$File:'.$File.'<br />';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;'.'$submit_vars:';echo var_dump($submit_vars).'<br /><br />';
		} 
		return true;
	}
		
	//属性
	public	$Url;
	private	$File;			//地址/文件名.php
	public 	$submit_vars = '';
	
	private	$time;
	private	$content;
	
	private $_show_log = true;
	//Protected	能在当前类和继承类中访问
	//private	只能在当前类中被调用

//类的相对结构,可以直接用来调用方法	
//parent::
//self::	

	/**
	 * 检查目标是否正确的网址
	 */
	private function is_url($url){
	    $url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
	    if ( !$url || $url=="" ) return false;
	    if ( !( $parts = @parse_url( $url ) ) ) return false;
	    else {
	    	if (!isset($parts['scheme'])) return false;
	        	if ( $parts['scheme'] != "http" && $parts['scheme'] != "https" && $parts['scheme'] != "ftp" ) return false;
	        
	        else if (!isset($parts['host'])) return false;
	        	if ( !preg_match( "/^[0-9a-z]([-.]?[0-9a-z])*.[a-z]{2,4}$/i", $parts['host'], $regs ) ) return false;
	        
	        else if (isset($parts['user']))
	        	if ( !preg_match( "/^([0-9a-z-]|[_])*$/i", $parts['user'], $regs ) ) return false;
	        	
	        else if (isset($parts['pass']))
	        	if ( !preg_match( "/^([0-9a-z-]|[_])*$/i", $parts['pass'], $regs ) ) return false;
	        	
	        else if (isset($parts['path']))	
	        	if ( !preg_match( "/^[0-9a-z\/_.@~-]*$/i", $parts['path'], $regs ) ) return false;
	        	
	        else if (isset($parts['query']))
	        	if ( !preg_match( "/^[0-9a-z?&=#,]*$/i", $parts['query'], $regs ) ) return false;
	    }
	    return true;
	}	
	
	//更新参数
	public function setUrl($url)
	{
		$Url = $url;
		if($this->is_url($Url)){
			$this->Url = $Url;
			return true;
		}else{
			if($this->_show_log) echo 'false:$this->is_url('.$Url.')<br /><br />';	
			return false;
		}
	}	
		
	public function setFile($file)
	{
		$File = $file;
		
		$File = str_replace('\\','/', $File);
		$File = preg_replace('/\/+/is','/', $File);
		$File = str_replace('//','/', $File);		
		if(!preg_match ("/[^\w\-\.\/\\\\@\#\%\&\*\(\)\+\?]+/i", $File)){
			$this->File = $File;
			return true;
		}else{
			if($this->_show_log) echo '(preg_match ("/[^\w\-\.\/\\\\@\#\%\&\*\(\)\+\?]+/i", '.$File.')<br />';
			return false;
		}
	}	
	
	public function setSubmit($submit_vars)
	{
		$Submit_vars = $submit_vars;
		
		if($Submit_vars != ''){
			if(is_array($Submit_vars)){
				$this->submit_vars = $Submit_vars;
				return true;
			}else{
				if($this->_show_log) echo 'false:is_array('.$Submit_vars.')<br /><br />';	
				return false;
			}
		}
	}	
		
	public function getContent(){
		return $this->content;
	}	
	
	// 获取缓存内容
	function getCache()
	{
		$filename=$this->File;
		
		if(file_exists($filename)){
			if($content_gz_cache = gzfile($filename)){			 
				$this->content = implode('', $content_gz_cache);
				$this->time = filemtime($filename);
				return true;
			}else{
				if($this->_show_log) echo 'false:$content_gz_cache = gzfile('.$filename.')<br /><br />';	
				return false;
			}
		}else{
			if($this->_show_log) echo 'false:file_exists('.$filename.')<br /><br />';		
			return false;
		}
	}	
	
	function saveCache(){
		$filename=$this->File;
		
		if (file_exists($filename)) {			
			$fp=gzopen($filename,"r");
			$content_old = gzread($fp,strlen($this->content));
			gzclose($fp);
			if($content_old == $this->content){		
				if($this->_show_log) echo 'The content Unchanged'.'<br />';		
				return true;
			}else{
				if($this->_show_log) echo 'The content changed'.'<br />';
				unlink($filename);
				$fp=gzopen($filename,"w9");
			}
		}else{
			$cut_file = explode('/', $filename);
			$cut_file_n = count($cut_file);
			if($cut_file_n > 1){
				$cut_dir_file = explode($cut_file[($cut_file_n-1)], $filename);				
				if(@mkdir($cut_dir_file[0], 0755, true)){
					if($this->_show_log) echo 'mkdir: '.$cut_dir_file[0].'<br />';	
				}
			}
			$fp=gzopen($filename,"w9");
		}
		
		if($content_gzed_len = gzwrite($fp, $this->content)){
			gzclose($fp);	
			if($this->_show_log) echo 'Save Cache size: ' .filesize($filename).'<br /><br />';		
			return true;
		}else{
			if($this->_show_log) echo 'Save Content error'.'<br /><br />';
			return false;
		}
		
	}

	function delCache(){
		$filename=$this->File;
		
		if(!@unlink($filename)){
			if($this->_show_log) echo 'false:unlink('.$filename.');<br />';
			return false;
		}
		if($this->_show_log) echo 'unlink('.$filename.');<br />';
		
		$file_cut = explode('/', $filename);
		//print_r($file_cut);
		$file_cut_count = count($file_cut);
		if($file_cut_count == 1){
			if($this->_show_log) echo 'true:delCache();<br /><br />';
			return true;
		}else{
			if($this->_show_log) echo 'rmdir: <br />';
			$filename_rev = strrev($filename);				
			for($i = ($file_cut_count-1); $i != 0; $i--){	
				$cut_dir_tmp = explode(strrev($file_cut[($i)]), $filename_rev, 2);
				$cut_dir = strrev($cut_dir_tmp[1]);
				//print_r($cut_dir) ;	
				//if($this->_show_log) echo '$file_cut['.$i.']:'.$file_cut[$i];
				if($this->_show_log) echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$i.' : rmdir('.$cut_dir.');<br />';

				if(!rmdir($cut_dir)){
					if($this->_show_log) echo 'false:delCache();<br /><br />';
					return false;
				}
				unset($cut_dir);
				
				$filename_rev = $cut_dir_tmp[1];
				unset($cut_dir_tmp);
			}			
		}
		
		if($this->_show_log) echo 'true:delCache();<br /><br />';
		return true;
	}
	
	// 获取链接内容
	function getURL()
	{	
		$submit_vars = $this->submit_vars;
		$url = $this->Url;
		
		$snoopy = new Snoopy();			//下载类构造
		// set browser and referer:
		$snoopy->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		$snoopy->referer = "http://www.baidu.com/";
		// set an raw-header:
		$snoopy->rawheaders["Pragma"] = "no-cache";
		// set some internal variables:
		//$snoopy->maxredirs = 2;
		//$snoopy->offsiteok = false;
		//$snoopy->expandlinks = false;
		if(is_array($submit_vars)){
			$get_state = $snoopy->submit($url,$submit_vars);
		}else{
			$get_state = $snoopy->fetch($url);
		}
		
		if($get_state){
			$this->content = $snoopy->results;
			$this->time = time();
			if($this->_show_log) echo 'Get Page size: ' .strlen($this->content).'<br /><br />';	
			return true;
		}else{
			return false;
		}
	}
	
	public function Get($cache=true){
		if($cache){
			if($this->getCache()){
				return true;
			}else{
				if($this->_show_log) echo 'false:Get(\'$cache=true\')<br /><br />';
				return false;
			}
		}else{		
			if($this->getURL()){				
				$this->saveCache();
				return true;
			}else{
				if($this->_show_log) echo 'false:Get(\'$cache=false\')<br /><br />';
				return false;
			}
		}
	}
	
	//析构函数
	/*
	public function __destruct()
	{
		
	}
	*/	
}
	
	//创建一个对象的实例
	$get_content_obj = new get_from_url_cache("http://www.google.com", "xx/xx/xxx\as/x/dfsdf/xx.xx/du.html");
	
	//$get_content_obj->getURL();
	
	//$get_content_obj->saveCache();
	
	//$get_content_obj->getCache();
	
	if($get_content_obj->Get(false)){
		
	}
	//$get_content_obj->delCache();
	


