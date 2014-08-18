<?php
/* @var $this WeblogController */
/* @var $model Weblog */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID'); ?>
		<?php echo $form->textField($model,'ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Title'); ?>
		<?php echo $form->textField($model,'Title',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Author'); ?>
		<?php echo $form->textField($model,'Author'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CreatedUTC'); ?>
		<?php echo $form->textField($model,'CreatedUTC'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'UpdatedUTC'); ?>
		<?php echo $form->textField($model,'UpdatedUTC'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Content'); ?>
		<?php echo $form->textArea($model,'Content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ResourcePath'); ?>
		<?php echo $form->textField($model,'ResourcePath',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->