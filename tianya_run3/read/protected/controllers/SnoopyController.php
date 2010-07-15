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
		$snoopy = new Snoopy();
	
		if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'])
		{
			
	        echo json_encode($_GET['ajax']);
	        Yii::app()->end(); // Not necessarily required, but it can't hurt
		}else{			
			$this->render('index',array('model'=>$model));
		}
	}

}