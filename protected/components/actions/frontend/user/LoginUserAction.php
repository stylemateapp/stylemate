<?php
/**
 * Controller class action for log-in of user through web API
 *
 * AngularJS application is sending credentials to this action waiting for provided answers
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class LoginUserAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $credentials = ResponseHelper::getRequestData();

        $model           = new LoginFormFrontend();
        $model->username = strip_tags($credentials['username']);
        $model->password = strip_tags($credentials['password']);

        if ($model->validate() && $model->login()) {

            ResponseHelper::sendResponse(200, array('success' => true));
        }
    }
}