<?php
/**
 * Controller class action for retrieving of user styles through web API
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

class GetUserStylesAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $styles     = CommonHelper::activeRecordToArray(Category::getCategoriesByGroup(Yii::app()->params['styleGroupId']));
        $userStyles = CommonHelper::activeRecordToArray($user->userStyles);

        $selectedStyles = array();

        foreach($styles as $key => $style) {

            $found = false;

            foreach($userStyles as $userStyle) {

                if($userStyle['id'] == $style['id']) {

                    $found            = true;
                    $selectedStyles[] = $style['id'];
                    break;
                }
            }

            if($found) {

                $styles[$key]['selected'] = 'selected';
            }
            else {

                $styles[$key]['selected'] = '';
            }
        }

        ResponseHelper::sendResponse(
            200,
            array('success' => true, 'styles' => $styles, 'selectedStyles' => $selectedStyles)
        );
    }
}