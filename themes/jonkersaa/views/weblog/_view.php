<?php
/* @var $this WeblogController */
/* @var $data Weblog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Title')); ?>:</b>
	<?php echo CHtml::encode($data->Title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Author')); ?>:</b>
	<?php echo CHtml::encode($data->Author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CreatedUTC')); ?>:</b>
	<?php echo CHtml::encode($data->CreatedUTC); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UpdatedUTC')); ?>:</b>
	<?php echo CHtml::encode($data->UpdatedUTC); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Content')); ?>:</b>
	<?php echo CHtml::encode($data->Content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ResourcePath')); ?>:</b>
	<?php echo CHtml::encode($data->ResourcePath); ?>
	<br />


</div>