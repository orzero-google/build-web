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
	public function __construct($Url, $File)
	{	
		if($this->is_url($Url)){
			$this->Url = $Url;
		}else{
			return false;
		}
		$File = str_replace('\\','/', $File);
		$File = preg_replace('/\/+/is','/', $File);
		$File = str_replace('//','/', $File);		
		$this->File = $File;
		$this->time = time();
		$this->content = '';
	}
		
	//属性
	public	$Url;
	private	$File;			//地址/文件名.php
	
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
		$this->Url = $url;
	}	
		
	public function setFile($file)
	{
		$this->File = $file;
	}	
	
	public function getContent(){
		return $this->content;
	}	
	
	// 获取缓存内容
	function getCache()
	{
		$filename=$this->File;
		
		if($content_gz_cache = gzfile($filename)){			 
			$this->content = implode('', $content_gz_cache);
			return true;
		}else{
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
				return false;
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
				if($this->_show_log) echo 'mkdir: '.$cut_dir_file[0].'<br />';	
				@mkdir($cut_dir_file[0], 0755, true);
			}
			$fp=gzopen($filename,"w9");
		}
		
		if($content_gzed_len = gzwrite($fp, $this->content)){
			gzclose($fp);	
			if($this->_show_log) echo 'Save Cache size: ' .filesize($filename).'<br />';		
			return true;
		}else{
			if($this->_show_log) echo 'Save Content error'.'<br />';
			return false;
		}
		
	}

	function delCache(){
		$filename=$this->File;

		if(!unlink($filename)){
			return false;
		}
		
		$file_cut = explode('/', $filename);
		//print_r($file_cut);
		$file_cut_count = count($file_cut);
		if($file_cut_count == 1){
			return true;
		}else{
			if($this->_show_log) echo 'rmdir: <br />';
			for($i = ($file_cut_count-1); $i != 0; $i--){			
				$cut_dir = explode($file_cut[$i], $filename , -1);	
				//print_r($cut_dir) ;	
				echo 	$file_cut[$i];
				if($this->_show_log) echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$i.' : '.$cut_dir[0].'<br />';
				$st_del = @rmdir($cut_dir[0]);
				if($st_del === false){
					//return false;
				}
				unset($cut_dir);
			}			
		}
		return true;
	}
	
	// 获取链接内容
	function getURL($submit_vars='')
	{
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
			if($this->_show_log) echo 'Get Page size: ' .strlen($this->content).'<br />';	
			return true;
		}else{
			return false;
		}
	}
	
	public function Get(){
		
	}
	
	//析构函数
	/*
	public function __destruct()
	{
		
	}
	*/	
}
	
	//创建一个对象的实例
	$get_content_obj = new get_from_url_cache("http://www.tianya.cn/publicforum/content/feeling/1/1210531.shtml", "xxc/xx/a/du.html");
	
	$get_content_obj->getURL();
	
	$get_content_obj->saveCache();
	
	//echo $get_content_obj->getCache();
	
	$get_content_obj->delCache();
	


