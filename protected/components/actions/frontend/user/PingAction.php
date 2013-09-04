<?php
/**
 * Controller class action for pinging through web API
 *
 * Used in AngularJS application
 *
 * In order to use this action user should be already authenticated (this fact is ensured using ApiRequestFilter)
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class PingAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        ResponseHelper::sendResponse(
            200,
            array(
                 'success' => true,
            )
        );
    }
}