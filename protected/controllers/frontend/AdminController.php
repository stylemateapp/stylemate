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
                'category'       => 'application.components.actions.common.Manage',
                'categoryDelete' => 'application.components.actions.common.Delete',
                'index'          => 'application.components.actions.frontend.admin.IndexAdminAction',
                'categoryCreate' => 'application.components.actions.frontend.admin.category.CreateCategoryAction',
                'categoryUpdate' => 'application.components.actions.frontend.admin.category.UpdateCategoryAction',
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