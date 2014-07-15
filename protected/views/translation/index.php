<?php
/* @var $this TranslationController */
/* @var $model Messages */

?>

<h1><?php echo Yii::t($this->id, 'Vertalingen'); ?> - <?php echo ('none'==$lang ? 'Onvertaald' : Yii::app()->locale->getLanguage($lang)) ?></h1>

<p>
    <?php echo Yii::t($this->id, 'Kies een taal') ?>:
    <a href="<?php echo $this->createUrl('translation/index', array('lang'=>'nl')); ?>"><?php echo Yii::app()->locale->getLanguage('nl') ?></a> |
    <a href="<?php echo $this->createUrl('translation/index', array('lang'=>'en')); ?>"><?php echo Yii::app()->locale->getLanguage('en') ?></a> |
    <a href="<?php echo $this->createUrl('translation/index', array('lang'=>'de')); ?>"><?php echo Yii::app()->locale->getLanguage('de') ?></a> |
    <a href="<?php echo $this->createUrl('translation/index', array('lang'=>'fr')); ?>"><?php echo Yii::app()->locale->getLanguage('fr') ?></a>
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'messages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'template'=>'{summary} {pager} {items} {pager}',
	'columns'=>array(
		'category',
        array(
            'name'=>'message',
            'type'=>'raw',
            //'value'=>'CHtml::tag("div",array("title"=>$data->message), $data->message)',
            'headerHtmlOptions'=>array('style'=>'width:30%;'),
        ),
        array(
            'type'=>'raw',
            'name'=>'translations.translation',
            'header'=>'Vertaling - '.Yii::app()->locale->getLanguage($lang),
            'value'=>'($data->translations && $data->translations[0] ? $data->translations[0]->translation : "")',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'updateButtonUrl'=>'Yii::app()->createUrl("translation/update",array("lang"=>"'.$lang.'","id"=>$data->id))',
            'deleteButtonUrl'=>'Yii::app()->createUrl("translation/delete",array("lang"=>"'.$lang.'","id"=>$data->id))',
		),
	),
));
