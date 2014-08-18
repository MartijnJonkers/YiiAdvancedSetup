<?php
/* @var $this TranslationController */
/* @var $message Messages */
/* @var $translated MessagesTranslation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-form',
)); ?>

	<div class="row">
		<?php echo $form->labelEx($message,'category'); ?>
		<?php echo $form->textField($message,'category',array('disabled'=>true)); ?>
		<?php echo $form->error($message,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($message,'message'); ?>
		<?php echo $form->textArea($message,'message',array('rows'=>4, 'cols'=>50, 'readonly'=>true)); ?>
		<?php echo $form->error($message,'message'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($translated,'language'); ?>
        <?php echo $form->textField($translated,'language',array('disabled'=>true, 'value'=>Yii::app()->locale->getLanguage($translated->language))); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($translated,'translation'); ?>
        <?php echo $form->textArea($translated,'translation',array('rows'=>4, 'cols'=>50, 'focus'=>true)); ?>

        <?php echo $form->textArea($translated, 'translation', array('rows' => 2, 'cols' => 80, 'class' => 'wtranslate-wysiwyg', 'style' => 'width:750px;')); ?>
        <?php echo $form->error($translated,'translation'); ?>
    </div>

	<div class="row buttons">
        <?php echo CHtml::label('&nbsp;','') ?>
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->