<?php
$this->breadcrumbs=array(
	'Contents'=>array('index'),
	$model->contentid,
);

$this->menu=array(
	array('label'=>'List Content', 'url'=>array('index')),
	array('label'=>'Create Content', 'url'=>array('create')),
	array('label'=>'Update Content', 'url'=>array('update', 'id'=>$model->contentid)),
	array('label'=>'Delete Content', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->contentid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>

<h1>View Content #<?php echo $model->contentid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'contentid',
		'info_id',
		'pg_id',
		'page_num',
		'channel_cn',
		'url',
		'dir',
		'time',
		'posts',
	),
)); ?>
