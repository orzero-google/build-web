<?php
$this->breadcrumbs=array(
	'Infos'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Info', 'url'=>array('index')),
	array('label'=>'Create Info', 'url'=>array('create')),
	array('label'=>'Update Info', 'url'=>array('update', 'id'=>$model->infoid)),
	array('label'=>'Delete Info', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->infoid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Info', 'url'=>array('admin')),
);
?>

<h1>View Info #<?php echo $model->infoid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'infoid',
		'name',
		'type',
		'channel_en',
		'channel_cn',
		'title',
		'author_id',
		'author_name',
		'pid_list',
		'count',
		'time',
	),
)); ?>
