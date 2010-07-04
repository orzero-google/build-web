<?php
//IMPORTANT:
//Rename this file to configuration.php after having inserted all the correct db information
global $configuration;
$configuration['soap'] = "http://www.phpobjectgenerator.com/services/pog.wsdl";
$configuration['homepage'] = "http://www.phpobjectgenerator.com";
$configuration['revisionNumber'] = "";
$configuration['versionNumber'] = "3.0e";

//$configuration['pdoDriver']	= 'mysql';
$configuration['setup_password'] = '';


// to enable automatic data encoding, run setup, go to the manage plugins tab and install the base64 plugin.
// then set db_encoding = 1 below.
// when enabled, db_encoding transparently encodes and decodes data to and from the database without any
// programmatic effort on your part.
$configuration['db_encoding'] = 0;

// edit the information below to match your database settings

$configuration['db']	= 'tianya_run';		//	<- database name
$configuration['host'] 	= '127.0.0.1';	//	<- database host
$configuration['user'] 	= 'root';		//	<- database user
$configuration['pass']	= '';		//	<- database password
$configuration['port']	= '3306';		//	<- database port


//proxy settings - if you are behnd a proxy, change the settings below
$configuration['proxy_host'] = false;
$configuration['proxy_port'] = false;
$configuration['proxy_username'] = false;
$configuration['proxy_password'] = false;


//plugin settings
$configuration['plugins_path'] = dirname(__FILE__).'/plugins';  //absolute path to plugins folder, e.g c:/mycode/test/plugins or /home/phpobj/public_html/plugins

Date_default_timezone_set("PRC");	//设定为中华人民共和国

//是否显示日志
$set = array();
$set['show_log'] = false;

//程序根目录
$set['root'] = '/data0/htdocs/read_orzero_com';
$set['include_config'] = true;
$set['tianya_data'] = 'data/tianya';
