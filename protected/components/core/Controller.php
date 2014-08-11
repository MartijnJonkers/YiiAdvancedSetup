<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';

    /**
    * Always user rights
    *
    */
    public function filters()
    {
        return [ "rights" ];
    }

    /**
    * put your comment there...
    *
    * @param CAction $action
    * @return boolean
    */
    public function beforeAction($action)
    {
        /* connect a scss file automaticly */
        if(isset( Yii::app()->theme )){

            /* get the path of the scss file */
            $path = Yii::app()->theme->basePath.'/scss/'.$this->id.'/'.$action->id.'.scss';

            /* does the file exist? */
            if(file_exists($path)){

                /* file is available, register it */
                Yii::app()->sass->register( $path );
            }
        }

        /* continue */
        return parent::beforeAction($action);
    }
}