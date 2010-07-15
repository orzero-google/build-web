<?php
/*
 +-------------------------------------------------------------------------------+
 | @description  :       通过curl函数实现远程页面的获取
 | @parameter    :
 | @export       :
 | @date         :       2010/07/12
 | @author       :       orzeroweb@gmail.com
 | @version      :       1.0
 +-------------------------------------------------------------------------------+
 */

include_once 'Snoopy.php';
include_once 'Command.php';

class Get{
	//属性
	public  $url    = '';
	public  $file   = '';                  //地址/文件名.php
	public  $submit = array();

	protected $snoopy;
	protected $content = '';
	protected $size    = 0;
	
	private $fp;
	private $_show_log = false;      //是否显示日志
	//protected     能在当前类和继承类中访问
	//private       只能在当前类中被调用

	//类的相对结构,可以直接用来调用方法    
	//parent::
	//self::

	//构造函数
	public function __construct($url='', $file='', $submit=array())
	{
		//$this->url    = $url;
		//$this->file   = $file;
		//$this->submit = $submit;		
		$this->snoopy = new Snoopy();
		
		$this->setSubmit($submit);

		if($this->setFile($file)){			
			$snoopy->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
			$snoopy->referer = "http://www.google.com/";
			$snoopy->rawheaders["Pragma"] = "no-cache";
		}

		if($this->setUrl($url)){
			$this->setFile($file);
		}

	}

	//采集
	public function setUrl($url)
	{
		if(is_url($url)){
			$this->url = $url;
			if(!empty($this->submit)){
				$get_state = $this->snoopy->submit($this->url,$this->submit);
			}else{
				$get_state = $this->snoopy->fetch($this->url);
			}
			if($get_state){
				$this->content = $this->snoopy->results;
				$this->size = strlen($this->content);
				return true;
			}
		}

		return false;
	}

	//设置目标文件,如果目录不存在先创建目录,同时保存内容
	public function setFile($file)
	{
		if(empty($file)){
			return false;
		}else{
			//更新了文件保存地址
			if($file !== $this->file){
				$this->closeFile();
			}
		}
		if ($this->fp) {
			if(($len = gzwrite($fp, $this->content)) === (strlen($this->content))){
				$this->size = $len;
				$this->file = $file;
				return true;
			}
		} else {
			$dir = dirname($file);
			if(mkdirs($dir)){
				if ($this->fp=gzopen($file,"w9")) {
					if(($len = gzwrite($fp, $this->content)) === (strlen($this->content))){
						$this->size = $len;
						$this->file = $file;
						return true;
					}
				}
			}
		}
		return false;
	}

	public function setSubmit($submit)
	{
		if(is_array($submit) && !empty($submit)){
			$this->submit = $submit;
			return true;
		}

		return false;
	}

	public function getContent(){
		return $this->content;
	}

	public function getSize(){
		return $this->size;
	}
	 
	// 获取缓存内容
	function getFile()
	{
		$filename=$this->file;
		if(file_exists($filename)){
			if($content_gz_cache = gzfile($filename)){
				$this->content = implode('', $content_gz_cache);
				$this->size = filesize($filename);
				return true;
			}
		}
		return false;
	}

	// 关闭文件
	function closeFile()
	{
		if($this->file != ''){
			gzclose($this->fp);
			unset($this->fp);
		}
	}
	

	//析构函数
	public function __destruct()
	{
		$this->closeFile();
	}

}
 


