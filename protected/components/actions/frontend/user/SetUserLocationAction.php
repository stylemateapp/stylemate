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
        $addingNewLocationAllowed = true;

        $user = User::model()->findByPk(Yii::app()->user->id);

        if(sizeof($user->locations) >= 5) {

            $addingNewLocationAllowed = false;
        }

        /**
         * THIS IS CASE OF DEFAULT LOCATION SETTING
         *
         * $user = User::model()->findByPk(Yii::app()->user->id);

        $user->setScenario('setLocation');*/

        if ($addingNewLocationAllowed) {

            $credentials  = ResponseHelper::getRequestData();
            $locationName = strip_tags($credentials['location']);

            $location = Location::model()->findByAttributes(
                array(
                     'user_id' => Yii::app()->user->id,
                     'name'    => $locationName
                )
            );

            if(is_null($location)) {

                $location = new Location();
                $location->user_id = Yii::app()->user->id;
                $location->name    = $locationName;

                if ($location->save()) {

                    ResponseHelper::sendResponse(200, array('success' => true));

                } else {

                    ResponseHelper::sendResponse(
                        400,
                        array('success'     => false,
                             'errorMessage' => ResponseHelper::returnValidationErrorsString($location->errors)
                        )
                    );
                }
            }
        }
        else {

            ResponseHelper::sendResponse(
                400,
                array('success' => false, 'errorMessage' => ResponseHelper::returnValidationErrorsString($user->errors))
            );
        }
    }
}