<?php
$this->breadcrumbs=array(
	'Pgs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Pg', 'url'=>array('index')),
	array('label'=>'Create Pg', 'url'=>array('create')),
	array('label'=>'Update Pg', 'url'=>array('update', 'id'=>$model->pgid)),
	array('label'=>'Delete Pg', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pgid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pg', 'url'=>array('admin')),
);
?>

<h1>View Pg #<?php echo $model->pgid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pgid',
		'name',
		'url',
		'dir',
		'type',
		'form_vars',
		'fid',
		'tid',
		'time',
		'page_size',
		'cache_size',
		'state',
	),
)); ?>
