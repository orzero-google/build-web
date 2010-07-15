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
		$info    = new Info();
		$pg      = new Pg();
		$content = new Content();
	
		if (isset($_REQUEST['ajax']) && $url=$_REQUEST['ajax'])
		{
			$get->setUrl($url);
			$the_page = $get->getContent();
			//echo json_encode(htmlentities($get->getContent()));
	        //echo json_encode($_GET['ajax']);
	        Yii::app()->end(); // Not necessarily required, but it can't hurt
		}else{			
			$this->render('index',array('model'=>$model));
		}
	}

}