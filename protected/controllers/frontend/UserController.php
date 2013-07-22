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
                'login' => 'application.components.actions.frontend.user.LoginUserAction',
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