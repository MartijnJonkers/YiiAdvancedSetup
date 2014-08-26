<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?php echo Yii::app()->language; ?>" />
    <?php Yii::app()->sass->register( Yii::app()->theme->basePath.'/scss/main.scss' ,'','theme.resources','css_compiled'); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <?php /* google analytics */ ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-53798107-1', 'auto');
      ga('send', 'pageview');
    </script>
    <?php /* end google analytics */ ?>

    <?php  $this->renderPartial('//layouts/_flashdialog'); ?>

    <div class="container" id="page">

        <div id="header">
            <div class="left">
                <div class="content">
                    <?php echo CHtml::image(Theme::$assetsUrl.'/img/logo.png','',array('class'=>'logo')) ?>
                    <br />
                    <?php $this->widget('tstranslation.widgets.TsLanguageWidget', array(
                        //'dynamicTranslate' => true,
                        'includeBootstrap' => false, // if in your project bootstrap.js loaded already
                        'type'=>'inline',
                        'itemTemplate' => '{flag}',
                    )); ?>
                </div>
            </div>
            <div class="right">
                <div class="content">
                    <div class="box">

                    </div>
                </div>
            </div>
            <?php

                $u = Yii::app()->user;
                $this->widget('application.extensions.mbmenu.MbMenu',array(
                    'encodeLabel'=>false,
                    'items'=>array(
                        array(
                            'label'=>Yii::t('mainmenu','translate button'),
                            'url'=>Yii::app()->controller->createUrl(
                                Yii::app()->controller->id.'/'.Yii::app()->controller->action->id,
                                array_merge($_GET,array('translate'=>Yii::app()->user->getState('translate')?0:1) )
                            ),
                            'visible'=>$u->checkAccess('Translation.*'),
                            'active'=>Yii::app()->user->getState('translate',false),
                            'itemOptions'=>array('style'=>'float:right;'),
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','home button'),
                            'url'=>array('/site/index'),
                            'visible'=>$u->checkAccess('Site.index'),
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','diensten button'),
                            'url'=>array('/diensten/index'),
                            'visible'=>$u->checkAccess('Diensten.index'),
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','news button'),
                            'url'=>array('/weblog/index'),
                            'visible'=>$u->checkAccess('Weblog.index'),
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','administrator button'),
                            'url'=>array($u->isAdmin() ? 'user/admin/admin' : 'user/user/index' ),
                            'visible'=>!$u->isGuest,
                            'items'=>array(
                                array(
                                    'label'=>Yii::t('mainmenu','users button'),
                                    'url'=>array($u->isAdmin() ? '/user/admin/admin' : '/user/user/index' ),
                                    'visible'=>$u->checkAccess( $u->isAdmin() ? 'User.Admin.Admin' : 'User.User.Index'),
                                    'active'=>($this->module && $this->module->id == 'user'),
                                ),
                                array(
                                    'label'=>Yii::t('mainmenu','translations button'),
                                    'url'=>array('/translation'),
                                    'visible'=>$u->checkAccess('Translation.*'),
                                    'active'=>($this->id == 'translation'),
                                ),
                                array(
                                    'label'=>Yii::t('mainmenu','rights button'),
                                    'url'=>array('/rights/authItem/permissions'),
                                    'visible'=>$u->isAdmin(),
                                    'active'=>($this->module && $this->module->id == 'rights'),
                                ),
                            )
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','login button'),
                            'url'=>array('/user/login/login'),
                            'visible'=>$u->checkAccess('User.Login.Login') && $u->isGuest,
                        ),
                        array(
                            'label'=>Yii::t('mainmenu','logout button'),
                            'url'=>array('/user/logout/logout'),
                            'visible'=>!$u->isGuest,
                        ),
                    ),
                    'htmlOptions'=>array(
                        'class'=>'box',
                    )
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
                //Yii::app()->translate->renderMissingTranslationsEditor();
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
