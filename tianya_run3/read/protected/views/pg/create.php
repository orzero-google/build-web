<?php
$this->breadcrumbs=array(
	'Pgs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pg', 'url'=>array('index')),
	array('label'=>'Manage Pg', 'url'=>array('admin')),
);
?>

<h1>Create Pg</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>