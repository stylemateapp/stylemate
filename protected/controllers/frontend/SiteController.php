<?php

    /**
     * Main Site controller class
     *
     * Is used for index page, actions like login / logout / recover of lost password etc.
     *
     * @author    Smirnov Egor <egorsmir@gmail.com>
     * @link      http://lastdayz.ru
     * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
     *
     */

    class SiteController extends Controller
    {
        /**
         * Declares class-based actions.
         * @return array
         */

        public function actions()
        {
            return array(
                'index' => 'application.components.actions.frontend.site.IndexSiteAction',
            );
        }

        /**
         * This is the action to handle external exceptions.
         */

        public function actionError()
        {
            if (($error = Yii::app()->errorHandler->error)) {

                if (Yii::app()->request->isAjaxRequest) {

                    echo $error['message'];
                } else {

                    $this->render('error', $error);
                }
            }
        }

        /**
         * Displays the login page
         */

        public function actionLogin()
        {
            $model = new LoginForm;

            // if it is ajax validation request

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {

                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['LoginForm'])) {

                $model->attributes = $_POST['LoginForm'];

                if ($model->validate() && $model->login()) {

                    if(Yii::app()->user->role === 'administrator') {

                        $this->redirect(Yii::app()->user->adminRedirectUrl);
                    }
                    else {

                        $this->redirect(Yii::app()->user->returnUrl);
                    }
                }
            }

            $this->render('login', array('model' => $model));
        }

        /**
         * Logs out the current user and redirect to homepage.
         */

        public function actionLogout()
        {
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        }
    }