<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('contentid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->contentid), array('view', 'id'=>$data->contentid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('info_id')); ?>:</b>
	<?php echo CHtml::encode($data->info_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pg_id')); ?>:</b>
	<?php echo CHtml::encode($data->pg_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('page_num')); ?>:</b>
	<?php echo CHtml::encode($data->page_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_cn')); ?>:</b>
	<?php echo CHtml::encode($data->channel_cn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dir')); ?>:</b>
	<?php echo CHtml::encode($data->dir); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posts')); ?>:</b>
	<?php echo CHtml::encode($data->posts); ?>
	<br />

	*/ ?>

</div>