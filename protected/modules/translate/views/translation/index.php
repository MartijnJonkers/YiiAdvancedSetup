<?php
/* @var $this TranslationController */
/* @var $model Messages */

?>

<h1><?php echo Yii::t($this->id, 'Vertalingen'); ?> - <?php echo ('none'==$lang ? 'Onvertaald' : Yii::app()->locale->getLanguage($lang)) ?></h1>

<p>
    <?php echo Yii::t($this->id, 'Kies een taal') ?>:
    <ul>
    <?php
        foreach( Language::getLanguages() as $key => $language ) {
            echo '<li>'.CHtml::tag(
                'a',
                array( 'href'=>$this->createUrl('translation/index', array('lang'=>$key)) ),
                Yii::app()->locale->getLanguage($key)
            ).'</li>';
        }
    ?>
    </ul>
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
            'name'=>'mt.translation',
            'header'=>'Vertaling - '.Yii::app()->locale->getLanguage($lang),
            'value'=>'($data->mt && $data->mt[0] ? $data->mt[0]->translation : "")',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'updateButtonUrl'=>'Yii::app()->createUrl("translate/translation/update",array("lang"=>"'.$lang.'","id"=>$data->id))',
            'deleteButtonUrl'=>'Yii::app()->createUrl("translate/translation/delete",array("lang"=>"'.$lang.'","id"=>$data->id))',
		),
	),
));
