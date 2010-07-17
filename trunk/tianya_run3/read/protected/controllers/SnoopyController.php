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
		$info    = new Info();
		$pg      = new Pg();
		$content = new Content();
	
		if (isset($_REQUEST['ajax']) && $url=$_REQUEST['ajax'])
		{
			$get->setUrl($url);
			$the_page = $get->getContent();
			$nav  = $tianya->get_link($the_page);		//取得导航,$post,$get
			if($nav){
				$info = $tianya->get_info($the_page,$nav['type']);		//取得文章信息
				//echo json_encode(gbk2utf8($info['chrTitle']));
				
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