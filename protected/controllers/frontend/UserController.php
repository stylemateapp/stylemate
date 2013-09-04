<?php

    /**
     * User controller class
     *
     * @author    Smirnov Egor <egorsmir@gmail.com>
     * @link      http://lastdayz.ru
     * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
     *
     */

    class UserController extends Controller
    {
        /**
         * Declares class-based actions.
         * @return array
         */

        public function actions()
        {
            return array(
                'login'              => 'application.components.actions.frontend.user.LoginUserAction',
                'logout'             => 'application.components.actions.frontend.user.LogoutUserAction',
                'signUp'             => 'application.components.actions.frontend.user.SignUpUserAction',
                'getLocations'       => 'application.components.actions.frontend.user.GetUserLocationsAction',
                'setLocation'        => 'application.components.actions.frontend.user.SetUserLocationAction',
                'setDefaultLocation' => 'application.components.actions.frontend.user.SetUserDefaultLocationAction',
                'deleteLocation'     => 'application.components.actions.frontend.user.DeleteUserLocationAction',
                'getStyles'          => 'application.components.actions.frontend.user.GetUserStylesAction',
                'setStyles'          => 'application.components.actions.frontend.user.SetUserStylesAction',
                'getWeather'         => 'application.components.actions.frontend.user.GetWeatherAction',
                'getOccasions'       => 'application.components.actions.frontend.user.GetOccasionsAction',
                'getImages'          => 'application.components.actions.frontend.user.GetImagesAction',
                'getUserInfo'        => 'application.components.actions.frontend.user.GetUserInfoAction',
                'ping'               => 'application.components.actions.frontend.user.PingAction',
            );
        }

        /**
         * @return array action filters
         */

        public function filters()
        {
            return array(
                array('application.components.filters.ApiRequestFilter'),
            );
        }
    }