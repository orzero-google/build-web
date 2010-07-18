<?php
$this->breadcrumbs=array(
	'Caches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cache', 'url'=>array('index')),
	array('label'=>'Manage Cache', 'url'=>array('admin')),
);
?>

<h1>Create Cache</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>