<?php
/**
 * Controller class action for log-out of user through web API
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class LogoutUserAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        Yii::app()->user->logout();
    }
}