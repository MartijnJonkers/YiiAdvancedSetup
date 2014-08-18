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
        <?php echo $form->label($message,'category'); ?>
		<?php echo $form->textField($message,'category',array('disabled'=>true, 'style'=>'border: none; background: transparent;')); ?>
		<?php echo $form->error($message,'category'); ?>
	</div>
    <div class="row">
        <?php echo $form->label($translated,'language'); ?>
        <?php echo $form->textField($translated,'language',array('disabled'=>true, 'value'=>Yii::app()->locale->getLanguage($translated->language) , 'style'=>'border: none; background: transparent;')); ?>
    </div>
	<div class="row">
        <?php echo $form->label($message,'message'); ?>
		<?php echo $form->textField($message,'message',array('disabled'=>true, 'style'=>'border: none; background: transparent;')); ?>
		<?php echo $form->error($message,'message'); ?>
	</div>
    <div class="row">
        <?php //echo $form->labelEx($translated,'translation'); ?>
        <?php //echo $form->textArea($translated,'translation',array('rows'=>4, 'cols'=>50, 'focus'=>true)); ?>
        <?php
            $this->widget('ext.editMe.widgets.ExtEditMe', array(
                'model'=>$translated,
                'attribute'=>'translation',
            ));
        ?>
        <?php echo $form->error($translated,'translation'); ?>
    </div>

	<div class="row buttons">
        <?php //echo CHtml::label('&nbsp;','') ?>
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->