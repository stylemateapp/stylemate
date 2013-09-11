<?php
/**
 * Controller class action for reminding of user password
 *
 * AngularJS application is sending email or username
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class RemindUserPasswordAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $credentials = ResponseHelper::getRequestData();

        $user = null;

        if (!empty($credentials['userData'])) {

            $userData = strip_tags($credentials['userData']);

            $user = User::model()->findByAttributes(array('email' => $userData));

            if (is_null($user)) {

                $user = User::model()->findByAttributes(array('username' => $userData));
            }
        }

        if (!is_null($user)) {

            $email           = Yii::app()->email;
            $email->to       = $user->email;
            $email->subject  = 'Stylemate password remind';
            $email->view     = 'remindPassword';
            $email->viewVars = array('username' => $user->username, 'password' => $user->password);

            if ($email->send()) {

                ResponseHelper::sendResponse(200, array('success' => true));

            } else {

                ResponseHelper::sendResponse(200, array('success' => false, 'errorMessage' => 'Can\'t send you a letter'));
            }


        } else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => 'User with provided credentials was not found')
            );
        }
    }
}