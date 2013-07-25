<?php
/**
 * Controller class action for setting of user location through web API
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class SetUserLocationAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $credentials = ResponseHelper::getRequestData();

        $user = User::model()->findByPk(Yii::app()->user->id);

        $user->setScenario('setLocation');
        $user->location = $credentials['location'];

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