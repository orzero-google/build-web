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
		//$model = new Snoopy('admin','admin');
		//$page = $model->fetch('http://www.baidu.com');
		
		if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'])
		{
	        echo json_encode('xami');
	        Yii::app()->end(); // Not necessarily required, but it can't hurt
		}else{
			$this->render('index',array('model'=>$model));
		}
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionJs()
	{
		echo '
function handeSuccess(data){
	alert(data);
}
function handeGeturl(){
	
}
		';
	}
}