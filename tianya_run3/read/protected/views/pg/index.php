<?php
$this->breadcrumbs=array(
	'Pgs',
);

$this->menu=array(
	array('label'=>'Create Pg', 'url'=>array('create')),
	array('label'=>'Manage Pg', 'url'=>array('admin')),
);
?>

<h1>Pgs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
