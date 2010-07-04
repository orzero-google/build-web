<?php
$this->breadcrumbs=array(
	'Contents'=>array('index'),
	$model->contentid=>array('view','id'=>$model->contentid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Content', 'url'=>array('index')),
	array('label'=>'Create Content', 'url'=>array('create')),
	array('label'=>'View Content', 'url'=>array('view', 'id'=>$model->contentid)),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>

<h1>Update Content <?php echo $model->contentid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>