<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pageid'); ?>
		<?php echo $form->textField($model,'pageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'furl'); ?>
		<?php echo $form->textField($model,'furl',array('size'=>60,'maxlength'=>1023)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channel_en'); ?>
		<?php echo $form->textField($model,'channel_en',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channel_cn'); ?>
		<?php echo $form->textField($model,'channel_cn',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author_name'); ?>
		<?php echo $form->textField($model,'author_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tpid'); ?>
		<?php echo $form->textField($model,'tpid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcount'); ?>
		<?php echo $form->textField($model,'pcount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'plist'); ?>
		<?php echo $form->textArea($model,'plist',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->