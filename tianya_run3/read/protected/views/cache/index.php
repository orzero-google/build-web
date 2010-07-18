<?php
$this->breadcrumbs=array(
	'Caches',
);

$this->menu=array(
	array('label'=>'Create Cache', 'url'=>array('create')),
	array('label'=>'Manage Cache', 'url'=>array('admin')),
);
?>

<h1>Caches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
