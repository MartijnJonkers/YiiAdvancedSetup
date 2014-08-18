<?php
/* @var $this WeblogController */
/* @var $model Weblog */

$this->breadcrumbs=array(
	'Weblogs'=>array('index'),
	$model->Title=>array('view','id'=>$model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Weblog', 'url'=>array('index')),
	array('label'=>'Create Weblog', 'url'=>array('create')),
	array('label'=>'View Weblog', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage Weblog', 'url'=>array('admin')),
);
?>

<h1>Update Weblog <?php echo $model->ID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>