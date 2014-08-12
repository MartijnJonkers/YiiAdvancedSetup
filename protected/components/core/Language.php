<?php

class Language extends CComponent
{
    /**
    * Load the current selected language
    *
    */
    public function init()
    {
        /* Handle language changes */
        if ($_GET['lang']) {
            $this->setLanguage($lang);

            /* redirect back if reffered */
            if (null != Yii::app()->request->urlReferrer) {
                Yii::app()->request->redirect(Yii::app()->request->urlReferrer);
            }
        } else {
            $this->setLanguage( self::getLanguage() );
        }
    }

    private function setLanguage( $lang )
    {
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
