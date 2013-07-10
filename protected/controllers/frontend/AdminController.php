<?php

    /**
     * Admin controller class
     *
     * is not in backend part of site for simplicity
     *
     * @author    Smirnov Egor <egorsmir@gmail.com>
     * @link      http://lastdayz.ru
     * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
     *
     */

    class AdminController extends Controller
    {
        public $layout = '//layouts/admin';

        /**
         * Declares class-based actions.
         * @return array
         */

        public function actions()
        {
            return array(
                'index' => 'application.components.actions.frontend.admin.IndexAdminAction',
            );
        }

        /**
         * @return array action filters
         */

        public function filters()
        {
            return array(
                'accessControl',
            );
        }

        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
            return array(
                array(
                    'allow',
                    'roles' => array('administrator'),
                ),
                array(
                    'deny', // deny all users
                    'users' => array('*'),
                ),
            );
        }
    }