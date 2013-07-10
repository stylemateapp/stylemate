<?php
/**
 * Controller class action for site index action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class IndexSiteAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $this->controller->render('index');
    }
}