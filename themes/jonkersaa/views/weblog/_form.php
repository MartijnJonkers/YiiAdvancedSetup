<?php
/* @var $this WeblogController */
/* @var $model Weblog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'weblog-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Title'); ?>
		<?php echo $form->textField($model,'Title',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'Title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Author'); ?>
		<?php echo $form->textField($model,'Author'); ?>
		<?php echo $form->error($model,'Author'); ?>
	</div>

	<div class="row" style='display:none'>
		<?php echo $form->labelEx($model,'CreatedUTC'); ?>
		<?php echo $form->textField($model,'CreatedUTC'); ?>
		<?php echo $form->error($model,'CreatedUTC'); ?>
	</div>

	<div class="row" style='display:none'>
		<?php echo $form->labelEx($model,'UpdatedUTC'); ?>
		<?php echo $form->textField($model,'UpdatedUTC'); ?>
		<?php echo $form->error($model,'UpdatedUTC'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Content'); ?>
		<?php echo $form->textArea($model,'Content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Content'); ?>
	</div>

	<div class="row" style='display:none'>
		<?php echo $form->labelEx($model,'ResourcePath'); ?>
		<?php echo $form->textField($model,'ResourcePath',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'ResourcePath'); ?>
	</div>

	<div class="row buttons">
        <?php echo CHtml::label('',''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->