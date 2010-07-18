<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pageid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pageid), array('view', 'id'=>$data->pageid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('furl')); ?>:</b>
	<?php echo CHtml::encode($data->furl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_en')); ?>:</b>
	<?php echo CHtml::encode($data->channel_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_cn')); ?>:</b>
	<?php echo CHtml::encode($data->channel_cn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_id')); ?>:</b>
	<?php echo CHtml::encode($data->author_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_name')); ?>:</b>
	<?php echo CHtml::encode($data->author_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pcount')); ?>:</b>
	<?php echo CHtml::encode($data->pcount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('plist')); ?>:</b>
	<?php echo CHtml::encode($data->plist); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	*/ ?>

</div>