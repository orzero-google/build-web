<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'furl'); ?>
		<?php echo $form->textField($model,'furl',array('size'=>60,'maxlength'=>1023)); ?>
		<?php echo $form->error($model,'furl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'channel_en'); ?>
		<?php echo $form->textField($model,'channel_en',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'channel_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'channel_cn'); ?>
		<?php echo $form->textField($model,'channel_cn',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'channel_cn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id'); ?>
		<?php echo $form->error($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_name'); ?>
		<?php echo $form->textField($model,'author_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pcount'); ?>
		<?php echo $form->textField($model,'pcount'); ?>
		<?php echo $form->error($model,'pcount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'plist'); ?>
		<?php echo $form->textArea($model,'plist',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'plist'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->