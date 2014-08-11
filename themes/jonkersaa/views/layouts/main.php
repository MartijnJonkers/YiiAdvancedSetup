<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?php echo Yii::app()->translate->language; ?>" />
    <?php Yii::app()->sass->register( Yii::app()->theme->basePath.'/scss/main.scss' ); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="container" id="page">


        <div id="header">
            <?php $this->widget('application.components.MainMenu' ); ?>
        </div>

	    <?php
            /* page content */
            echo $content;
        ?>

        <?php
            /* missing translations */
            if ( Yii::app()->user->checkAccess('Translate.Translate.Create') ) {
                Yii::app()->translate->renderMissingTranslationsEditor();
            }
        ?>

	    <div class="clear"></div>

	    <div id="footer">
		    Copyright &copy; <?php echo date('Y'); ?> by Jonkers AA. |  All Rights Reserved. | <?php echo Yii::powered(); ?>
	    </div><!-- footer -->

    </div><!-- page -->
</body>
</html>
