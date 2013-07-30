<?php
/**
 * Controller class action for retrieving of all occasions through web API
 *
 * Used in AngularJS application
 *
 * In order to use this action user should be already authenticated (this fact is ensured using ApiRequestFilter)
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class GetOccasionsAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $occasions  = CommonHelper::activeRecordToArray(Category::getCategoriesByGroup(Yii::app()->params['occasionGroupId']));

        ResponseHelper::sendResponse(
            200,
            array('success' => true, 'occasions' => $occasions)
        );
    }
}