<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /* Add additional error codes */
    const ERROR_ACCOUNT_BLOCKED=3;
    const ERROR_PASSWORD_RESET=4;

    public $_id;
    private $_user;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $user = User::model()->find( 'Email=:email', array(':email'=>$this->username) );

        /* All sorts of possible problems */
		if( is_null($user) )
        {
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
        }
        elseif( !$user->validatePassword( $this->password ) )
        {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
		else
        {
            /* Success! */
            $this->logInUser($user);
        }
		return !$this->errorCode;
	}

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
    * Usefull for impersonating another user...
    * http://www.yiiframework.com/wiki/154/impersonate-users-within-yii-framework
    */
    protected function logInUser($user)
    {
        if( $user )
        {
            $this->_user = $user;
            $this->_id = $this->_user->ID;
            $this->username = $this->_user->Email;
            $this->errorCode = self::ERROR_NONE;
        }
    }

    /**
    * Make the current user impersonate an other userId
    * @param integer $userId the userId to impersonate
    * @return UserIdentity the new userIdentity
    */
    public static function impersonate($userId)
    {
        $newUI = null;
        $user = User::model()->findByPk($userId);
        if ( $user )
        {
            $newUI = new UserIdentity($user->Email, "");
            $newUI->logInUser($user);
        }
        return $newUI;
    }

    /**
    * Restore all the data needed for the users SESSION
    */
    public static function restoreUserSession()
    {
        /* Determine the user role(s) */
        $roles = Yii::app()->authManager->getRoles(Yii::app()->user->id);
        if ( in_array( User::ROLE_ADMIN, array_keys($roles) ) )
        {
            /* Admin */
            Yii::app()->user->setState('siteAdmin', true);
        }

        /* Get the user */
        $user = User::model()->findByPk( Yii::app()->user->id );
        Yii::app()->user->setState('email',     $user->Email);
        Yii::app()->user->setState('name',      $user->Name.' '.$user->LastName);
        Yii::app()->user->setState('firstname', $user->Name);
        Yii::app()->user->setState('lastname',  $user->LastName);
        Yii::app()->user->setState('username',  $user->UserName);
    }
}