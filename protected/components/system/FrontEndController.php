<?php
/**
 * Front End controller for frontend part of the site
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2011-2012 Smirnov Egor aka LastDay
 * 
 */

abstract class FrontEndController extends Controller
{
    public $defaultAction = 'view';
    protected $actionSubPath = 'application.components.actions.frontend.';
    protected $defaultActions =
        array(
            /*'create' => 'application.components.actions.CreateAction',
            'update' => 'application.components.actions.UpdateAction',
            'view'   => 'application.components.actions.ViewAction',*/
        );

    /**
     * init of controller
     * @return void
     */
    
    public function init()
    {
        parent::init();

        if(isset ($_GET['lang']))
        {
            Yii::app()->language = $_GET['lang'];
        }
        
        $this->actionSubPath .= strtolower($this->getId()) . '.';
    }

    /**
     * @return array
     */

    public function actions()
    {
        return $this->defaultActions;
    }

    /**
	 * @return array action filters
	 */

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
                'roles' => array('user'),
            ),
            array(
                'allow',
                'actions' => array('login'),
                'users'   => array('?'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
	}
}