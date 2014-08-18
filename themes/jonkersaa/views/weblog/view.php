<?php
/* @var $this WeblogController */
/* @var $model Weblog */

$this->breadcrumbs=array(
	'Weblogs'=>array('index'),
	$model->Title,
);

$this->menu=array(
	array('label'=>'List Weblog', 'url'=>array('index')),
	array('label'=>'Create Weblog', 'url'=>array('create')),
	array('label'=>'Update Weblog', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete Weblog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Weblog', 'url'=>array('admin')),
);
?>

<h1>View Weblog #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'Title',
		'Author',
		'CreatedUTC',
		'UpdatedUTC',
		'Content',
		'ResourcePath',
	),
)); ?>
