<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    public $username;
    public $password;
    public $rememberMe;

    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required, but we don't require it in activeForms
            array('username, password', 'required'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username'=>Yii::t(__CLASS__,'Uw e-mail adres'),
            'password'=>Yii::t(__CLASS__,'Uw wachtwoord'),
            'rememberMe'=>Yii::t(__CLASS__,'Onthoud mijn inloggegevens'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            if(!$this->_identity->authenticate())
                $this->addError('password','Incorrect username or password.');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if( null === $this->_identity )
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            $this->_identity->authenticate();
        }
        if( UserIdentity::ERROR_NONE === $this->_identity->errorCode )
        {
            $duration=$this->rememberMe ? 3600*24*30 : 0;
            Yii::app()->user->login($this->_identity, $duration);
            $this->_identity->restoreUserSession(Yii::app()->user);

            return true;
        }
        else
            return false;
    }

    /**
    * @return integer ErrorCode the current UserIdentity::errorcode of the authenticated state
    */
    public function getErrorCode()
    {
         if ( null == $this->_identity )
            return UserIdentity::ERROR_UNKNOWN_IDENTITY;
        return $this->_identity->errorCode;
    }

}

