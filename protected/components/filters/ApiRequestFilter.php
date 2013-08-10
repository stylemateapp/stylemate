<?php

    /**
     * This is pre-filter analyzing session information received from frontend
     *
     * @author    Smirnov Egor <egorsmir@gmail.com>
     * @link      http://lastdayz.ru
     * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
     */

    class ApiRequestFilter extends CFilter
    {
        protected $ignoredControllers = array(
            array('controller' => 'user', 'action' => 'login'),
            array('controller' => 'user', 'action' => 'signUp'),
        );

        /**
         * @param CFilterChain $filterChain
         *
         * @return bool
         */

        public function preFilter(CFilterChain $filterChain)
        {
            $controllerIsInIgnoreList = false;

            foreach($this->ignoredControllers as $controller) {

                if($controller['controller'] == Yii::app()->controller->id && $controller['action'] == Yii::app()->controller->action->id) {

                    $controllerIsInIgnoreList = true;
                }
            }

            if($controllerIsInIgnoreList) {

                $filterChain->run();
            }
            else {

                if (!Yii::app()->user->isGuest) {

                    $user = User::model()->findByPk(Yii::app()->user->id, array('select' => 'id, role'));

                    if(is_null($user)) {

                        Yii::app()->user->logout();
                        ResponseHelper::sendResponse(401);
                    }

                    $filterChain->run();

                } else {

                    ResponseHelper::sendResponse(401);
                }
            }
        }
    }