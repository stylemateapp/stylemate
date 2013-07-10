<?php
/**
 * Controller class action for admin index action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class IndexAdminAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $this->controller->render('index');
    }
}