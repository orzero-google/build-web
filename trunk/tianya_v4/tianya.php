<?php 
include_once 'GetPg.class.php';
        //创建一个对象的实例
        $get_content_obj = new get_from_url_cache("http://www.google.com", "xx/xx/xxx\as/x/dfsdf/xx.xx/du.html");
       
        //$get_content_obj->getURL();
       
        //$get_content_obj->saveCache();
       
        //$get_content_obj->getCache();
       
        if($get_content_obj->Get(false)){
               
        }
        //$get_content_obj->delCache();

include_once './configuration.php';
include_once './objects/class.database.php';
include_once './objects/class.pg.php';
$pg = new PG('xxx','xxxx','xxxxx', 4, 'xxxxxxx', 5, 8, time(), 8, 2, 2);

print_r($pg);
echo $pg->Save();

