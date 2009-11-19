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

class get_from_url{	
	
	//构造函数
	public function __construct($url, $cacheFile)
	{
		$this->url = $url;
		$this->cacheFile = $cacheFile;
		$this->time = time();
	}
		
	//属性
	public	$url;
	private	$cacheFile;			//地址/文件名.php
	private	$time;
	private	$content;
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
		$this->url = $url;
	}		
	public function setCache($cacheFile)
	{
		$this->cacheFile = $cacheFile;
	}	
	public function setContent($content)
	{	
		$this->content = $content;
	}
	
	
	// 获取缓存内容
	function getCache()
	{
		
	}	
	
	function saveCache(){
		$filename=$this->cacheFile;
		if (file_exists($filename)) {
			$fp=fopen($filename,"a");
		}else{
			$fp=fopen($filename,"w");
		}
		
		$text=$sql;
		fwrite($fp,$text);
		fclose($fp);
	}	
	
	// 获取链接内容
	function getURL($url,$submit_vars='')
	{
		
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
		}else{
			return false;
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
	$user = new User("Leon", "sdf123");
	
	//获取最后访问的时间
	print($user->getLastLogin() ."<br>\n");
	
	//打印用户名
	print("$user->name<br>\n"); 
	


