<?php

class SnoopyController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		$get     = new Get();
		$tianya  = new Tianya();
		//$info    = new Info();
		//$pg      = new Pg();
		//$content = new Content();
		$page  = new Page();

	
		if (isset($_REQUEST['ajax']) && $url=$_REQUEST['ajax'])
		{
			$get->setUrl($url);
			$the_page = $get->getContent();
			$the_nav  = $tianya->get_link($the_page);		//取得导航,$post,$get
			
			if($the_nav){
				$the_info = $tianya->get_info($the_page,$the_nav['type']);		//取得文章信息
				$the_pageid = $tianya->get_the_pageid($url);

				if($the_nav['link_r'][0] !== $the_pageid){
					$url = str_replace($the_pageid, $the_nav['link_r'][0], $url);
				}
								
				//入库文章信息,根据furl去重,有则更新,没有则插入
				$page_old = $page->find('furl=:furl', array(':furl' => $url));
				if($page_old->furl === $url){//以前采集过,则更新
					$page_old->title = gbk2utf8($the_info['chrTitle']);
					$page_old->channel_en = empty($the_info['intItem']) ? $the_info['chrItem'] : $the_info['intItem'];
					$page_old->channel_cn = gbk2utf8($the_info['channel_cn']);
					$page_old->author_id = empty($the_info['intAuthorId']) ? 0 : $the_info['intAuthorId'];
					$page_old->author_name = gbk2utf8($the_info['chrAuthorName']);
					$page_old->pcount = $the_nav['link_c'];
					$page_old->plist = serialize($the_nav['link_r']);
					$st = $page_old->save(false);
				}else{
					$page_new = new Page();
					$page_new->furl = $url;
					$page_new->title = gbk2utf8($the_info['chrTitle']);
					$page_new->channel_en = empty($the_info['intItem']) ? $the_info['chrItem'] : $the_info['intItem'];
					$page_new->channel_cn = gbk2utf8($the_info['channel_cn']);
					$page_new->author_id = empty($the_info['intAuthorId']) ? 0 : $the_info['intAuthorId'];
					$page_new->author_name = gbk2utf8($the_info['chrAuthorName']);
					$page_new->tpid = 1;
					$page_new->pcount = $the_nav['link_c'];
					$page_new->plist = serialize($the_nav['link_r']);
					$st = $page_new->save(false);
				}
				
				$_ajax['pid']       = empty($page_old->tpid) ? $page_new->tpid : $page_old->tpid; //页码
				$_ajax['pcount']       = empty($page_old->pcount) ? $page_new->pcount : $page_old->pcount; //总页数
				$_ajax['pcount']    = $the_nav['link_c'];       //页数
				$_ajax['list']      = $the_nav['link_r'];		//页序号列表
				$_ajax['furl']      = $url;						//首页
				$_ajax['turl']      = $url;					    //当前页	
				$_ajax['type']      = $the_nav['type'];	        //当前页类型
				$_ajax['channel_en']	= empty($page_old->channel_en) ? $page_new->channel_en : $page_old->channel_en;
				$_ajax['channel_cn']	= empty($page_old->channel_cn) ? $page_new->channel_cn : $page_old->channel_cn;
				$_ajax['author_name']	= empty($page_old->author_name) ? $page_new->author_name : $page_old->author_name;
				$_ajax['title']	        = empty($page_old->title) ? $page_new->title : $page_old->title;
				
				echo json_encode($_ajax);

				//json_encode(print_r($dataProvider));				
				
				//json_encode(print_r($st));
			}else{
	        	echo json_encode('不是天涯的网址,或者页数不超过1页，不予收录');
			}
			
			//echo json_encode(print_r($info));
			
	        Yii::app()->end(); // Not necessarily required, but it can't hurt
		}else{			
			$this->render('index',array('model'=>$page_old));
		}
	}
	
	public function actionSave()
	{
		$cache  = new Cache();		
		$tianya = new Tianya();
		$get    = new Get();
		
		//取参数
		$pid        = $_POST['pid'];
		$type       = $_POST['type'];
		$furl       = $_POST['furl'];
		$list       = $_POST['list'];
		$channel_en = $_POST['channel_en'];
		$pcount     = $_POST['pcount'];
		
		if(!empty($channel_en))
			$file = './data/'.$channel_en.'/'.md5($furl).'/'.$pid.'.php';
		else
			return false;
			
		$url_post = $tianya->mk_url($type, $furl, $list, $pid);
		$size = 0;
		
		
		if($type == 'get'){
			$turl = $url_post;
			if($get->setFile($file,false)){
				if($get->setUrl($turl)){
					$get->setFile($file);
					$size = $get->getSize();
				}
			}
		}else if($type == 'post'){
			$turl = serialize($url_post);
			if($get->setSubmit($url_post)){
				if($get->setFile($file)){
					if($get->setUrl($furl)){
						$size = $get->getSize();
					}
				}
			}
		}
		
		var_dump($get->getFile());
		//echo $size;
		
		
		//入库文章内容
		$cache->pid  = $pid;
		$cache->type = $type;
		$cache->furl = $furl;
		$cache->turl = $turl;
		$cache->file = $file;
		$cache->size = $size;
		$cache->status = ($pid === $pcount) ? 0 : 1;
		$cache->posts  = 0;
		$cache->time   = time();
	}
	
}