<?php

    /**
     * LoginForm class used in frontend.
     * LoginForm is the data structure for keeping
     * user login form data. It is used by the 'login' action of 'SiteController'.
     */

    class LoginFormFrontend extends CFormModel
    {
        public $username;
        public $password;
        public $rememberMe;

        private $_identity;

        /**
         * Declares the validation rules.
         * The rules state that username and password are required,
         * and password needs to be authenticated.
         * @return array
         * @codeCoverageIgnore
         */

        public function rules()
        {
            return array(
                array('username, password', 'required'),
                array('rememberMe', 'boolean'),
                array('password', 'authenticate'),
            );
        }

        /**
         * Declares attribute labels.
         * @return array
         *
         * @codeCoverageIgnore
         */

        public function attributeLabels()
        {
            return array(
                'rememberMe' => 'Remember Me',
                'username'   => 'Username',
                'password'   => 'Password',
            );
        }

        /**
         * Authenticates the password.
         * This is the 'authenticate' validator as declared in rules().
         *
         * @param string $attribute
         * @param array  $params
         *
         * @return void
         */

        public function authenticate($attribute, $params)
        {
            if (!$this->hasErrors()) {

                $this->_identity = new UserIdentity($this->username, $this->password);

                if (!$this->_identity->authenticate()) {

                    $this->addError('password', 'Username or password is incorrect.');
                }
            }
        }

        /**
         * Logs in the user using the given username and password in the model.
         * @return boolean whether login is successful
         */

        public function login()
        {

            if ($this->_identity === null) {

                $this->_identity = new UserIdentity($this->username, $this->password);
                $this->_identity->authenticate();
            }

            if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {

                $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                Yii::app()->user->login($this->_identity, $duration);

                return true;

            } else {

                return false;
            }
        }
    }
