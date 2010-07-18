<?php
$this->breadcrumbs=array(
	'Caches'=>array('index'),
	$model->cacheid=>array('view','id'=>$model->cacheid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cache', 'url'=>array('index')),
	array('label'=>'Create Cache', 'url'=>array('create')),
	array('label'=>'View Cache', 'url'=>array('view', 'id'=>$model->cacheid)),
	array('label'=>'Manage Cache', 'url'=>array('admin')),
);
?>

<h1>Update Cache <?php echo $model->cacheid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>