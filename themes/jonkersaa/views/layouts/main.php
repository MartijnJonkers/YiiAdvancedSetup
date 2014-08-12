<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?php echo Yii::app()->translate->language; ?>" />
    <?php Yii::app()->sass->register( Yii::app()->theme->basePath.'/scss/main.scss' ,'','theme.resources','css_compiled'); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="container" id="page">

        <div id="header">
            <div class="left">
                <div class="content">
                    <?php echo CHtml::image(Theme::$assetsUrl.'/img/logo.png','',array('class'=>'logo')) ?>
                </div>
            </div>
            <div class="right">
                <div class="content">
                    right
                </div>
            </div>
            <?php
                $u = Yii::app()->user;
                $this->widget('application.extensions.mbmenu.MbMenu',array(
                    'items'=>array(
                        array(
                            'label'=>Yii::t('mainmenu','Home'),
                            'url'=>array('/site/index'),
                            'visible'=>$u->checkAccess('Site.index')
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','Administrator'),
                            'url'=>array('#'),
                            'visible'=>!$u->isGuest,
                            'items'=>array(
                                array(
                                    'label'=>Yii::t('mainmenu','Users'),
                                    'url'=>array('/user'),
                                    'visible'=>$u->checkAccess('User.index')
                                ),
                                array(
                                    'label'=>Yii::t('mainmenu','Translations'),
                                    'url'=>array('/translate/translation'),
                                    'visible'=>$u->checkAccess('Translation.index')
                                ),
                                array(
                                    'label'=>Yii::t('mainmenu','Rights'),
                                    'url'=>array('/rights/authItem/permissions'),
                                    'visible'=>$u->isAdmin()
                                ),
                            )
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','Logout').' ('.$u->name.')',
                            'url'=>array('/user/logout'),
                            'visible'=>!$u->isGuest
                        ),
                    ),
                ));
            ?>
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


        <div id="pagefooter">

        </div>

    </div><!-- page -->

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by Jonkers AA |  All Rights Reserved. | <?php echo Yii::powered(); ?>
    </div><!-- footer -->
</body>
</html>
