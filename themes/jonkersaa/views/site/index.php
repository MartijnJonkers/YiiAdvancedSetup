<div id="blocks">
    <?php $this->renderPartial('_block',array(
        'title'=>Language::t('left title'),
        'text'=>Language::t('left text'),
        'imageClass'=>'left',
        'url'=>'#',
    )); ?>
    <?php $this->renderPartial('_block',array(
        'title'=>Language::t('middle title'),
        'text'=>Language::t('middle text'),
        'imageClass'=>'middle',
        'url'=>'#',
    )); ?>
    <?php $this->renderPartial('_block',array(
        'title'=>Language::t('right title'),
        'text'=>Language::t('right text'),
        'imageClass'=>'right',
        'url'=>array('site/index'),
    )); ?>
</div>