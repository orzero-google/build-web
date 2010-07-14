<?php

$filename = './big/s/b/t.txt';

function create_dir($path)
{
 $dirs=dirname($path);
 if(is_dir($dirs)) return ;
 $dirs = explode('/',$dirs);

 //判断操作系统，linux的话，去除第一项
 if(strpos($path,'/')===0)
 {
  $dirpath = '/';
  unset($dirs[0]);
 }
 while ($directory = array_shift($dirs))
 {
  $dirpath .= $directory.'/';
  if(!is_dir($dirpath))
  {
   mkdir($dirpath);
   if(!chmod($dirpath,0777))
   {
    die('mkdir fail！！');
   }
  }
 }
}

//create_dir($dir);
  function rrmdir($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    foreach (scandir($dir) as $item) {
      if ($item == '.' || $item == '..') continue;
      if (!rrmdir($dir.DIRECTORY_SEPARATOR.$item)) return false;
    }
    return rmdir($dir);
  } 

function mkdirs($pathname, $mode = 0755) {
is_dir(dirname($pathname)) || mkdirs(dirname($pathname), $mode);
return is_dir($pathname) || @mkdir($pathname, $mode);
}
  //删除缓存文件
  function delFile($file){
    //$file = $this->file;
    
    if(@unlink($file)){ 
      $dir = dirname($file);          
      while ($dir != $file):
      	  echo '@rmdir('.$dir.');'.'<br>';
          rmdir($dir);
          $file = $dir;
          $dir = dirname($file);
      endwhile;
      return true;
    }    
    
    return false;
  }
//echo mkdirs(dirname($filename));

      //if($fp=gzopen($filename,"w9"))
      //echo $len = gzwrite($fp, '123456789');
      
//mkdirs(dirname($filename));
//delFile($filename);

$p = file('http://www.tianya.cn');
$ps = implode("\n\r",$p);
echo $ps;

