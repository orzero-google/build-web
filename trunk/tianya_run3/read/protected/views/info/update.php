<?php
$this->breadcrumbs=array(
	'Infos'=>array('index'),
	$model->name=>array('view','id'=>$model->infoid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Info', 'url'=>array('index')),
	array('label'=>'Create Info', 'url'=>array('create')),
	array('label'=>'View Info', 'url'=>array('view', 'id'=>$model->infoid)),
	array('label'=>'Manage Info', 'url'=>array('admin')),
);
?>

<h1>Update Info <?php echo $model->infoid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>