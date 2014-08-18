<?php
/**
*
*/
class WUser extends RWebUser
{
    /**
    * init the WebUser component
    *
    */
    public function init()
    {
        // make rights module compatible with user module
        $this->behaviors = array( 'ext.web-user-behavior.WebUserBehavior' );

        // init parent
        parent::init();
    }
}
