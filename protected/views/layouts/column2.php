<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-5">
    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <?php $this->widget('application.components.MainMenu' ); ?>

    <div id="languages">
        <ul>
            <li class="<?php echo ('nl' === Yii::app()->language ? "nl" : "nl_bw"); ?>">
                <a id="lang_nl" title="Nederlands" href="<?php echo Yii::app()->createUrl('/?lang=nl'); ?>">NL</a>
            </li>
            <li class="<?php echo ('en' === Yii::app()->language ? "en" : "en_bw"); ?>">
                <a id="lang_en" title="English" href="<?php echo Yii::app()->createUrl('/?lang=en'); ?>">EN</a>
            </li>
            <li class="<?php echo ('de' === Yii::app()->language ? "de" : "de_bw"); ?>">
                <a id="lang_de" title="Deutsch" href="<?php echo Yii::app()->createUrl('/?lang=de'); ?>">DE</a>
            </li>
            <li class="<?php echo ('fr' === Yii::app()->language ? "fr" : "fr_bw"); ?>">
                <a id="lang_fr" title="Français" href="<?php echo Yii::app()->createUrl('/?lang=fr'); ?>">FR</a>
            </li>
        </ul>
    </div><!-- languages -->

</div>
<div class="span-19 last">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>

<?php $this->endContent(); ?>