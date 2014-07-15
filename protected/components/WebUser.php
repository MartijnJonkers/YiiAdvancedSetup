<?php
/**
*
*/
class WebUser extends RWebUser
{
    /**
    * Actions to be taken after logging in. Saves the login time on cookie
    * login and restores all the session variables needed  by the app
    *
    * @param boolean $fromCookie whether the login is based on cookie.
    */
    public function afterLogin($fromCookie)
    {
        if ($fromCookie)
        {
            $user = User::model()->findByPk( Yii::app()->user->id );
            if ( $user )
            {
                /* Set all the session variables */
                UserIdentity::restoreUserSession();
            }
        }
        /* Propogate event to parent class */
        parent::afterLogin($fromCookie);
    }
}
