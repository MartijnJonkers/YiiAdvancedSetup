<?php
/**
*
*/
class AppUser extends RWebUser
{
    public function init()
    {
        // make WebUser compatible with user module
        $this->behaviors = array( 'ext.web-user-behavior.WebUserBehavior' );

        // init parent
        parent::init();
    }

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

    static function SendMail( $to, $subject, $message )
    {
         $mail = new YiiMailer();
        //$mail->clearLayout();//if layout is already set in config
        $mail->setFrom('from@example.com', 'John Doe');
        $mail->setTo($to);
        $mail->setSubject($subject);
        $mail->setBody($message);
        $mail->send();
    }
}
