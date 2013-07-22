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
        /**
         * @param CFilterChain $filterChain
         *
         * @return bool
         */

        public function preFilter(CFilterChain $filterChain)
        {
            if(Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'login') {

                $filterChain->run();
            }
            else {

                if (!Yii::app()->user->isGuest) {

                    $filterChain->run();

                } else {

                    ResponseHelper::sendResponse(401);
                }
            }
        }
    }