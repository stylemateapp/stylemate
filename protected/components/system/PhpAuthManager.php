<?php

/**
 * AuthManager file
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2012 Smirnov Egor aka LastDay
 */

class PhpAuthManager extends CPhpAuthManager
{
    public function init()
    {
        // Auth Hierarchy is in 'config/auth.php'

        if($this->authFile === null)
        {
            $this->authFile = Yii::getPathOfAlias('application.config.auth') . '.php';
        }
 
        parent::init();

        if(User::model()->findByPk(Yii::app()->user->id) === null)
        {
            Yii::app()->user->logout();
        }
 
        // default role for guest is 'guest'

        if(!Yii::app()->user->isGuest)
        {
            // Linking the role from database with user's id
            // returning UserIdentity.getId()

            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }
    }
}