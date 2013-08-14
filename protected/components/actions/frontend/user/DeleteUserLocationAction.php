<?php
/**
 * Controller class action for deleting of user location through web API
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class DeleteUserLocationAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $credentials  = ResponseHelper::getRequestData();
        $locationName = strip_tags($credentials['location']);

        $location = Location::model()->findByAttributes(
            array(
                 'user_id' => Yii::app()->user->id,
                 'name'    => $locationName
            )
        );

        if (!is_null($location) && $location->delete()) {

            ResponseHelper::sendResponse(200, array('success' => true));
        }
        else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false)
            );
        }
    }
}