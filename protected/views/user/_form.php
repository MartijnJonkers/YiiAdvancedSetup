<?php
/* @var $this UserController */
/* @var $user User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
)); ?>

    <div class="row">
        <?php echo $form->labelEx($user,'Name'); ?>
        <?php echo $form->textField($user,'Name'); ?>
        <?php echo $form->error($user,'Name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($user,'LastName'); ?>
        <?php echo $form->textField($user,'LastName'); ?>
        <?php echo $form->error($user,'LastName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($user,'UserName'); ?>
        <?php echo $form->textField($user,'UserName'); ?>
        <?php echo $form->error($user,'UserName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($user,'Email'); ?>
        <?php echo $form->textField($user,'Email'); ?>
        <?php echo $form->error($user,'Email'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->