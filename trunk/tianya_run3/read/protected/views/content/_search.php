<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'contentid'); ?>
		<?php echo $form->textField($model,'contentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'info_id'); ?>
		<?php echo $form->textField($model,'info_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pg_id'); ?>
		<?php echo $form->textField($model,'pg_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_num'); ?>
		<?php echo $form->textField($model,'page_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channel_cn'); ?>
		<?php echo $form->textField($model,'channel_cn',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dir'); ?>
		<?php echo $form->textField($model,'dir',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'posts'); ?>
		<?php echo $form->textField($model,'posts'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->