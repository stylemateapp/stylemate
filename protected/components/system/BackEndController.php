<?php
/**
 * Back End controller for frontend part of the site
 * 
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2011-2012 Smirnov Egor aka LastDay
 * 
 */

abstract class BackEndController extends Controller
{
    public $defaultAction = 'list';
    protected $actionSubPath = 'components.actions.backend';

    /*
     * init of controller
     * @return void
     */

    public function init()
    {
        parent::init();

        $this->actionSubPath .= ucfirst($this->getId()) . '.';
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
                'actions' => array('login'),
                'users'   => array('?'),
            ),
            array('allow',
                'roles' => array('administrator'),
            ),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}
}