<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('infoid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->infoid), array('view', 'id'=>$data->infoid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_en')); ?>:</b>
	<?php echo CHtml::encode($data->channel_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_cn')); ?>:</b>
	<?php echo CHtml::encode($data->channel_cn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_id')); ?>:</b>
	<?php echo CHtml::encode($data->author_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('author_name')); ?>:</b>
	<?php echo CHtml::encode($data->author_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pid_list')); ?>:</b>
	<?php echo CHtml::encode($data->pid_list); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
	<?php echo CHtml::encode($data->count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	*/ ?>

</div>