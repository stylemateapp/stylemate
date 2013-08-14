<?php
/**
 * Controller class action for setting of default er location through web API
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class SetUserDefaultLocationAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $credentials = ResponseHelper::getRequestData();
        $latitude    = strip_tags($credentials['latitude']);
        $longitude   = strip_tags($credentials['longitude']);

        $address = GeoLocationHelper::getAddressByCoordinates($latitude, $longitude);

        if (!empty($address)) {

            if (!is_null($user->defaultLocation)) {

                $user->defaultLocation->delete();
            }

            $defaultLocation = Location::model()->findByAttributes(
                array(
                     'user_id' => Yii::app()->user->id,
                     'name'    => $address,
                )
            );

            if(is_null($defaultLocation)) {

                $defaultLocation          = new Location();
                $defaultLocation->user_id = Yii::app()->user->id;
                $defaultLocation->name    = $address;
            }

            if ($defaultLocation->save(false)) {

                $user->default_location = $defaultLocation->id;

                if ($user->save(false)) {

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
                } else {

                    ResponseHelper::sendResponse(
                        400,
                        array(
                             'success'      => false,
                             'errorMessage' => 'Cannot save default location'
                        )
                    );
                }
            }
        } else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => ResponseHelper::returnValidationErrorsString($user->errors))
            );
        }
    }
}