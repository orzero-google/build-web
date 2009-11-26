<?php

$cacheFile = '/////\/.///\//xxxxxxxxx\xxp\//g/';
		$cacheFile = str_replace('\\','/', $cacheFile);
		
		echo $cacheFile."\n";
		
		$cacheFile = preg_replace('/\/+/is','/', $cacheFile);
		
		$cacheFile = str_replace('//','/', $cacheFile);
		echo $cacheFile;
		
		$cacheFile = explode('g/', '');
		
		print_r($cacheFile);
		echo count($cacheFile);