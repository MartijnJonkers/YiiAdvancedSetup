<?php

class TranslationController extends Controller
{
    public function init()
    {
        /* inport modules from translation module */
        Yii::import('translate.models.*');
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$lang)
	{
        $message = $this->loadMessageModel($id);
		$translated = $this->loadTranslationModel($id,$lang);

        //if(isset($_POST['TextTranslation']))
        if(isset($_POST['Message']))
		{
			$translated->translation = $_POST['Message']['translation'];
            $translated->id = $id;
			if($translated->save())
				$this->redirect(array('index','lang'=>$lang));
		}
        if ('' == $translated->translation)
            $translated->translation = $message->message;

		$this->render('update',array('message'=>$message, 'translated'=>$translated, 'lang'=>$lang));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$lang)
	{
        /* delete current translation */
		$model = $this->loadTranslationModel($id,$lang);
        if(isset($model)) {
            if(!$model->isNewRecord)
                $model->delete();
        }

        /* delete completely when all translation deleted */
        $count = Message::model()->count(array(//TextTranslation::model()->count(array(
            'condition'=>'id=:id',
            'params'=>array(':id'=>$id)
        ));
        if($count == 0){
            MessageSource::model()->findByPk($id)->delete();//Text::model()->findByPk($id)->delete();
        }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all translations.
	 */
	public function actionIndex($lang='en')
	{
        $model=new MessageSource('search');//Text('search');
        $model->unsetAttributes();  // clear any default values

        $model->language=$lang;

        //if(isset($_GET['Text']))
        if(isset($_GET['MessageSource']))
			$model->attributes=$_GET['MessageSource'];//$_GET['Text'];

		$this->render('index',array('model'=>$model, 'lang'=>$lang));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the message model to be loaded
	 * @param string $lang the language
	 * @return MessagesTranslation the loaded model
	 * @throws CHttpException
	 */
	public function loadTranslationModel($id,$lang)
	{
		$model = Message::model()->find(array(//TextTranslation::model()->find(array(
            'condition'=>'id=:id AND language=:lang',
            'params'=>array(
                ':id'=>$id,
                ':lang'=>$lang
            )));
		if($model===null)
        {
			$model = new Message;//new TextTranslation;
            $model->language = $lang;
        }
		return $model;
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the message model to be loaded
     * @return MessagesTranslation the loaded model
     * @throws CHttpException
     */
    public function loadMessageModel($id)
    {
        $model = MessageSource::model()->findByPk($id);//Text::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
