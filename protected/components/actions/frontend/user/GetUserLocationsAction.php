<?php
/**
 * Controller class action for retrieving of user locations array through web API
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

class GetUserLocationsAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        if (!empty($user->defaultLocation->name)) {

            $coordinates = GeoLocationHelper::getCoordinatesByAddress($user->defaultLocation->name);

            $defaultLocation = array(
                'name'      => $user->defaultLocation->name,
                'latitude'  => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
            );

            $otherLocations = array();

            foreach ($user->otherLocations as $location) {

                $coordinates = GeoLocationHelper::getCoordinatesByAddress($location->name);

                $arr = array(
                    'name'      => $location->name,
                    'latitude'  => $coordinates['latitude'],
                    'longitude' => $coordinates['longitude'],
                );

                $otherLocations[] = $arr;
            }

            ResponseHelper::sendResponse(
                200,
                array(
                     'success'   => true,
                     'locations' => array(
                         'default'        => $defaultLocation,
                         'otherLocations' => $otherLocations
                     )
                )
            );
        } else {

            $user->tryToSetDefaultLocation();

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => 'User location is empty')
            );
        }
    }
}