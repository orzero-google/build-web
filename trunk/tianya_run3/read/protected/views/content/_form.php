<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'info_id'); ?>
		<?php echo $form->textField($model,'info_id'); ?>
		<?php echo $form->error($model,'info_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pg_id'); ?>
		<?php echo $form->textField($model,'pg_id'); ?>
		<?php echo $form->error($model,'pg_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'page_num'); ?>
		<?php echo $form->textField($model,'page_num'); ?>
		<?php echo $form->error($model,'page_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'channel_cn'); ?>
		<?php echo $form->textField($model,'channel_cn',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'channel_cn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dir'); ?>
		<?php echo $form->textField($model,'dir',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'dir'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'posts'); ?>
		<?php echo $form->textField($model,'posts'); ?>
		<?php echo $form->error($model,'posts'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->