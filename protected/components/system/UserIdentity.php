<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity
{
    private $_id;

    public function __construct($user, $password = false)
    {
        if(is_string($user))
        {
            parent::__construct($user, $password);
        }
        elseif(is_a($user, 'User'))
        {
            $this->_id = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }
    }



    /**
     * Authenticates a user.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */

    public function authenticate()
    {
        /**
         * @var User $user
         */
        if($this->errorCode == self::ERROR_NONE)
        {
            return self::ERROR_NONE;
        }

        $user = User::model()->findByAttributes(array('username' => $this->username));

        if ($user === null)
        {
            $user = User::model()->findByAttributes(array('email' => $this->username));
        }

        if($user === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else
        {
            if($user->password !== $this->password)
            {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
            else
            {
                $this->_id       = $user['id'];
                $this->errorCode = self::ERROR_NONE;
            }
        }

        return !$this->errorCode;
    }

    /**
     * @return int $id
     */

    public function getId()
    {
        return $this->_id;
    }
}