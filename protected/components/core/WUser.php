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

    /**
    * Send an email using phpmailer
    *
    * @param mixed $to  the mail address to send the message to
    * @param mixed $subject the subject of the email
    * @param mixed $message the message to send
    */
    static function SendMail( $to, $subject, $message , $atachments=null)
    {
        /* create mail object */
        $mail = new YiiMailer();

        //$mail->clearLayout();//if layout is already set in config

        /* todo: set from */
        $mail->setFrom('from@example.com', 'John Doe');

        /* build the mesage */
        $mail->setTo($to);
        $mail->setSubject($subject);
        $mail->setBody($message);

        /* add attachments when needed */
        if($atachments != null)
        {
            /* todo: add attachments */
        }

        /* send the message */
        $mail->send();
    }
}
