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

        /* Handle language changes */
        if (isset($_GET['lang'])) {
            $this->setLanguage($_GET['lang']);

            /* redirect back if reffered */
            if (null != Yii::app()->request->urlReferrer) {
                Yii::app()->request->redirect(Yii::app()->request->urlReferrer);
            }
        } else {
            $this->setLanguage( self::getLanguage() );
        }
    }

    private static $tranlationID = 0;
    private static $tranlationPrefix = 'editable_text_';

    /**
    * inline translations
    *
    * note: this only works for non clickable elements!
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

        if(Yii::app()->user->getState("translate",false))
        {
            $source = MessageSource::model()->findByAttributes(array('category' => $category,'message' => $text));
            $translation = Message::model()->findByPk(array('id'=>$source->id,'language'=>Yii::app()->language ));
            self::$tranlationID++;
            $htmlOptions['id'] = self::$tranlationPrefix.self::$tranlationID;


            $model = $translation ? $translation : $source;
            $attribute = $translation ? 'translation' : 'message';

            if($addBtn)
            {
                $model->$attribute .= CHtml::tag('i',array('class'=>'fa fa-pencil','style'=>'margin-left:5px;','onclick'=>"
                        event.stopPropagation();
                        $('#".self::$tranlationPrefix.self::$tranlationID."').editable('show');
                    "
                ),'',true);
            }

            $result = Yii::app()->controller->widget('editable.EditableField', array(
                'type' => 'textarea',
                'model' => $model,
                'attribute' => $attribute,
                'url' => Yii::app()->createUrl('/translate/translation/inlineUpdate',array('id'=>$source->id)),
                'placement' => 'right',
                'showbuttons' => 'bottom',
                'options'=>array(
                    'toggle' => $toggle,
                ),
                'htmlOptions'=>$htmlOptions,
                'encode'=>false,
            ),true);
            return $result;
        } else {
            return $translated;
        }
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

    private function setLanguage( $lang )
    {
        // find wheter language does exist
        if(!in_array($lang,array_keys($this->languages)))
            return;

        // Save language settings to sesion
        Yii::app()->translate->setLanguage( $lang );
        Yii::app()->user->setState('language', $lang );
        Yii::app()->setLanguage( $lang );
    }

    /**
    * get all the available languages
    *
    */
    public static function getLanguages()
    {
        // read all data from translate module
        $languages = Yii::app()->translate->languages;

        // convert language names to local names
        foreach( $languages as $key => $language )
        {
            $languages[$key] = Yii::app()->locale->getLanguage($key);
        }

        // return the languages
        return $languages;
    }

    /**
    * get the current language
    *
    */
    public static function getLanguage()
    {
        if ( Yii::app()->user->checkAccess('Translate.Translate.Create') ) {
            // get language from translate module
            $lang = Yii::app()->translate->getLanguage( );
        } else {
            // Get the users preffered language from the session
            $lang = Yii::app()->user->getState('language', false);
        }

        // did we get a language?
        if (false == $lang)
        {
            // language not set yet

            // get the preferred language for user
            $lang = substr(Yii::app()->request->preferredLanguage,0,2);

            // do have that language?
            if( !key_exists($lang, Yii::app()->translate->languages) )
            {
                // language not available

                // get the default language
                $lang = Yii::app()->translate->defaultLanguage;
            }
        }

        // return
        return $lang;
    }
}
?>
