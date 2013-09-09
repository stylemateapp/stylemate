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
        $user = User::model()->findByPk(Yii::app()->user->id);

        $credentials  = ResponseHelper::getRequestData();
        $locationName = strip_tags($credentials['location']);

        $location = Location::model()->findByAttributes(
            array(
                 'user_id' => Yii::app()->user->id,
                 'name'    => $locationName
            )
        );

        if (!is_null($location) && $location->delete()) {

            $user->tryToSetDefaultLocation();

            ResponseHelper::sendResponse(
                200,
                array(
                     'success'   => true,
                     'locations' => array(
                         'default'        => $user->defaultLocation,
                         'otherLocations' => $user->otherLocations
                     )
                )
            );
        }
        else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false)
            );
        }
    }
}