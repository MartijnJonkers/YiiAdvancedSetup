<?php

class Language extends CComponent
{
    /**
    * Load the current selected language
    *
    */
    public function init()
    {
        if(isset($_GET['translate'])){
            if(Yii::app()->user->checkAccess('Translate.*'))
                Yii::app()->user->setState("translate",$_GET['translate'] ? true : false);
        }
    }

    private static $tranlationID = 0;
    private static $tranlationPrefix = 'editable_text_';

    /**
    * inline translations
    *
    * note: this only works for non clickable elements, use Language::link for clickable elements.
    *
    * @param mixed $text original text
    * @param mixed $category category, defaults to module.controller.action
    * @return {CWidget|mixed|string}
    */
    public static function t( $text , $category = null, $toggle='click', $htmlOptions=array(), $addBtn = false)
    {
        if(!$category)
            $category = Yii::app()->controller->category;

        $translated =Yii::t( $category, $text );

        if(!Yii::app()->user->getState("translate",false))
            return $translated;

        $source = SourceMessages::model()->findByAttributes(array('category' => $category,'message' => $text));
        $translation = TranslatedMessages::model()->findByPk(array('id'=>$source->id,'language'=>Yii::app()->language ));
        self::$tranlationID++;
        $htmlOptions['id'] = self::$tranlationPrefix.self::$tranlationID;

        $model = $translation ? $translation : $source;
        $attribute = $translation ? 'translation' : 'message';

        if($addBtn)
        {
            $model->$attribute .= CHtml::tag('i',array('class'=>'fa fa-pencil','style'=>'margin-left:5px;','onclick'=>"
                event.stopPropagation();
                $('#".self::$tranlationPrefix.self::$tranlationID."').editable('show');
            "),'',true);
        }

        return Yii::app()->controller->widget('editable.EditableField', array(
            'type' => 'textarea',
            'model' => $model,
            'attribute' => $attribute,
            'url' => Yii::app()->createUrl('/translation/update',array('id'=>$source->id)),
            'placement' => 'right',
            'showbuttons' => 'bottom',
            'options'=>array( 'toggle' => $toggle ),
            'htmlOptions'=>$htmlOptions,
            'encode'=>false,
        ),true);
    }

    /**
    * translateable links
    *
    * @param mixed $text
    * @param string $url
    * @param mixed $category
    * @param array $htmlOptions
    * @return {CWidget|mixed|string}
    */
    public static function link( $text, $url = '#', $category = null, $htmlOptions=array() )
    {
        if(!$category)
            $category = Yii::app()->controller->category;
        $translated = Yii::t( $category, $text );

        if(!Yii::app()->user->getState("translate",false))
            return CHtml::link($translated,$url,$htmlOptions);

        if(is_array($url))
        {
            $path = $url[0];
            unset($url[0]);
            $params = $url;
            $url = Yii::app()->createUrl($path,$params);
        }
        $htmlOptions = array_merge( array('onclick'=>'window.location="'.$url.'"' ), $htmlOptions);

        //create translation button
        $result = Language::t($text,$category,'manual',$htmlOptions, true);

        return $result;
    }
}
?>
