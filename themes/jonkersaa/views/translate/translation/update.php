<?php
/* @var $this TranslationController */
/* @var $model Messages */

?>

<h1><?php echo Yii::t($this->id, 'Vertaling'); ?> - <?php echo Yii::app()->locale->getLanguage($lang) ?></h1>

<?php $this->renderPartial('_form', array('message'=>$message, 'translated'=>$translated, 'lang'=>$lang)); ?>