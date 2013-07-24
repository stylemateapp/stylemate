<?php
/**
 * Controller class action for sign up of user through web API
 *
 * AngularJS application is sending email / password action waiting for provided answers
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class SignUpUserAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $credentials = ResponseHelper::getRequestData();

        $user             = new User;
        $user->attributes = $credentials;

        if ($user->save()) {

            ResponseHelper::sendResponse(200, array('success' => true));
        }
        else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => ResponseHelper::returnValidationErrorsString($user->errors))
            );
        }
    }
}