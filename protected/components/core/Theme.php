<?php
class Theme extends CComponent
{
    public static $assetsUrl = '';

    public function init()
    {
        /* connect a scss file automaticly */
        if(isset( Yii::app()->theme )){

            /* get the path of the resource files */
            $path = Yii::app()->theme->basePath.'/resources/';

            /* does the path exist */
            if(file_exists($path))
            {
                /* set the alias */
                Yii::setPathOfAlias('theme.resources',$path);

                /* publish images */
                Theme::$assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('theme.resources'));
            }
        }
    }
}
?>
