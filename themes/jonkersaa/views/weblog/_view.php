<?php
/* @var $this WeblogController */
/* @var $data Weblog */
?>

<div class="view">

	<b><?php echo ($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo $data->getAttributeLabel('Title'); ?>:</b>
	<?php echo ($data->Title); ?>
	<br />

	<b><?php echo ($data->getAttributeLabel('Author')); ?>:</b>
	<?php echo ($data->Author); ?>
	<br />

	<b><?php echo ($data->getAttributeLabel('CreatedUTC')); ?>:</b>
	<?php echo ($data->CreatedUTC); ?>
	<br />

	<b><?php echo ($data->getAttributeLabel('UpdatedUTC')); ?>:</b>
	<?php echo ($data->UpdatedUTC); ?>
	<br />

	<b><?php echo ($data->getAttributeLabel('Content')); ?>:</b>
	<?php echo ($data->Content); ?>
	<br />

	<b><?php echo ($data->getAttributeLabel('ResourcePath')); ?>:</b>
	<?php echo ($data->ResourcePath); ?>
	<br />


</div>