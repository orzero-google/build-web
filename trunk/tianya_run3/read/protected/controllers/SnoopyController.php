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
		$cache = new Cache();
	
		if (isset($_REQUEST['ajax']) && $url=$_REQUEST['ajax'])
		{
			$get->setUrl($url);
			$the_page = $get->getContent();
			$the_nav  = $tianya->get_link($the_page);		//取得导航,$post,$get
			if($the_nav){
				$the_info = $tianya->get_info($the_page,$the_nav['type']);		//取得文章信息
				//echo json_encode(gbk2utf8($info['chrTitle']));
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
					$page_new->pcount = $the_nav['link_c'];
					$page_new->plist = serialize($the_nav['link_r']);
					$st = $page_new->save(false);
				}
				json_encode(print_r($st));
			}else{
	        	echo json_encode('不是天涯的网址,或者页数不超过1页，不予收录');
			}
			
			//echo json_encode(print_r($info));
			
	        Yii::app()->end(); // Not necessarily required, but it can't hurt
		}else{			
			$this->render('index',array('model'=>$model));
		}
	}

}