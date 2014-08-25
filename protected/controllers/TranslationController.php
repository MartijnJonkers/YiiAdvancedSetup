<?php
class TranslationController extends Controller
{
    public function actionIndex()
    {
        $this->render('index',array(
        ));
    }

    public function actionUpdate($id)
    {
        if( ! Yii::app()->request->isAjaxRequest )
            return;

        $source = $this->loadSourceModel( $id );
        $translated = $this->loadTranslatedModel( $id , Yii::app()->language );

        if(isset($_POST['value'])) {
            $translated->translation = $_POST['value'];
            $translated->id = $id;
            if(!$translated->save())
                throw new Exception("Failed to save data");
        } else {
            throw new Exception("Missing value");
        }
    }

    private function loadTranslatedModel($id,$lang)
    {
        $model = TranslatedMessages::model()->find(array(
            'condition'=>'id=:id AND language=:lang',
            'params'=>array(
            ':id'=>$id,
            ':lang'=>$lang
        )));

        if($model===null) {
            $model = new SourceMessages;
            $model->language = $lang;
        }
        return $model;
    }

    private function loadSourceModel($id)
    {
        $model = SourceMessages::model()->findByPk($id);//Text::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
?>
