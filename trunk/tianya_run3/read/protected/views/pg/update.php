<?php
$this->breadcrumbs=array(
	'Pgs'=>array('index'),
	$model->name=>array('view','id'=>$model->pgid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pg', 'url'=>array('index')),
	array('label'=>'Create Pg', 'url'=>array('create')),
	array('label'=>'View Pg', 'url'=>array('view', 'id'=>$model->pgid)),
	array('label'=>'Manage Pg', 'url'=>array('admin')),
);
?>

<h1>Update Pg <?php echo $model->pgid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>