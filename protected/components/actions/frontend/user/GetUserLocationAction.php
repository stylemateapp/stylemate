<?php
/**
 * Controller class action for retrieving of user location through web API
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

class GetUserLocationAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        if (!empty($user->location)) {

            ResponseHelper::sendResponse(200, array('success' => true));
        }
        else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => 'User location is empty')
            );
        }
    }
}