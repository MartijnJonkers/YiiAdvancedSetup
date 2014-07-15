<?php

class UserController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights',
        );
    }

 	/**
	 * Updates user
	 */
	public function actionUpdate($id)
	{
		$user=$this->loadModel($id);

		if(isset($_POST['User']))
		{
			$user->attributes=$_POST['User'];
			if($user->save())
            {
                Yii::app()->user->setFlash('success',Yii::t($this->id, 'Gebruikers gegevens bijgewerkt'));
				$this->redirect(array('index'));
            }
		}

		$this->render('update', array('user'=>$user));
	}

    /**
     * Delete user
     */
    public function actionDelete($id)
    {
        $user = $this->loadModel($id);

        if(isset($user))
        {
            $user->delete();
            Yii::app()->user->setFlash('success',Yii::t($this->id, 'Gebruiker is verwijderd'));
        }

        $this->redirect(array('index'));
    }

    /**
     * Create new user
     */
    public function actionCreate()
    {
        $user = new User();

        if(isset($_POST['User']))
        {
            $user->attributes = $_POST['User'];
            if($user->save())
            {
                Yii::app()->user->setFlash('success',Yii::t($this->id, 'Nieuwe gebruiker opgeslagen'));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array('user'=>$user));
    }

	/**
	 * Default action
	 */
	public function actionIndex()
	{
        $user = new User('search');
        $this->render('index', array('userModel'=>$user));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ibox the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ibox $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ibox-signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
