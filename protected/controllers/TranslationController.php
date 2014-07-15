<?php

class TranslationController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return [ 'rights' ];
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

		if(isset($_POST['TextTranslation']))
		{
			$translated->translation = $_POST['TextTranslation']['translation'];
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
        $count = TextTranslation::model()->count(array(
            'condition'=>'id=:id',
            'params'=>array(':id'=>$id)
        ));
        if($count == 0){
            Text::model()->findByPk($id)->delete();
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
        $model=new Text('search');
        $model->unsetAttributes();  // clear any default values

        $model->language=$lang;

		if(isset($_GET['Text']))
			$model->attributes=$_GET['Text'];

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
		$model = TextTranslation::model()->find(array(
            'condition'=>'id=:id AND language=:lang',
            'params'=>array(
                ':id'=>$id,
                ':lang'=>$lang
            )));
		if($model===null)
        {
			$model = new TextTranslation;
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
        $model = Text::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
