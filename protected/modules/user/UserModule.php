<?php

class UserModule extends UserModuleOriginal
{
    public static $mailClass = 'AppUser';
    public static $mailFunction = 'SendMail';

    /**
     * Send mail method
     */
    public static function sendMail($email,$subject,$message) {
        $expression = self::$mailClass.'::'.self::$mailFunction.'("'.$email.'","'.$subject.'","'.$message.'")';
        Yii::app()->evaluateExpression($expression);
    }
}

?>
