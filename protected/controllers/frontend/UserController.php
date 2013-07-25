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
                'login'       => 'application.components.actions.frontend.user.LoginUserAction',
                'signUp'      => 'application.components.actions.frontend.user.SignUpUserAction',
                'getLocation' => 'application.components.actions.frontend.user.GetUserLocationAction',
                'setLocation' => 'application.components.actions.frontend.user.SetUserLocationAction',
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

        /**
         *
         */

        public function actionLocation()
        {

        }
    }