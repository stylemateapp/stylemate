<?php

    /**
     * WebUser implementation
     *
     * @author Smirnov Egor <egorsmir@gmail.com>
     * @link http://lastdayz.ru
     * @copyright Copyright &copy; 2012 Smirnov Egor aka LastDay
     */

    class WebUser extends CWebUser
    {
        public $adminRedirectUrl = array('/admin/index');
        private static $model = null;

        /**
         * getting the model of user by primary key
         * @return User $model
         */

        private function getModel()
        {
            if(!$this->isGuest && self::$model === null)
            {
                self::$model = User::model()->findByPk($this->id, array('select' => 'id, role'));
            }

            return self::$model;
        }

        /**
         * getting role of user
         * @return string $role
         */

        function getRole()
        {
            if(($user = $this->getModel()))
            {
                return $user->role;
            }

            return null;
        }

        /**
         * Sets last_login
         */

        public function init()
        {
            parent::init();

            /*if(($user = $this->getModel()))
            {
                $user->last_login = new CDbExpression('NOW()');
                $user->save(false, array('last_login'));
            }*/
        }
    }