<?php

class Mail extends CApplicationComponent
{
    public $address = 'from@example.com';
    public $name = 'John Doe';

    /**
    * Send an email using phpmailer
    *
    * @param mixed $to  the mail address to send the message to
    * @param mixed $subject the subject of the email
    * @param mixed $message the message to send
    */
    function send( $to, $subject, $message , $atachments=null)
    {
        /* create mail object */
        $mail = new YiiMailer();

        //$mail->clearLayout();//if layout is already set in config

        /* todo: set from */
        $mail->setFrom($this->address, $this->name);

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
?>
