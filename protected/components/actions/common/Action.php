<?php

/**
 * Frontend Action Class
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2011 Smirnov Egor aka LastDay
 *
 * @property string $modelName
 * @property CActiveRecord $model
 *
 */

class Action extends CAction
{
    private $_modelName;
    private $_view;
    public $queryId = 0;
    public $events;

    /**
     * @param CController $controller
     * @param string      $id
     */

    public function __construct($controller, $id)
    {
        parent::__construct($controller,$id);

        $this->queryId = Yii::app()->request->getParam('id');

        if(method_exists($this, 'beforeRun'))
        {
            $this->beforeRun();
        }
    }

    /**
     * redirection of page after save
     * by default redirects to defaultAction of controller
     * @param string $actionId
    */

    public function redirect($actionId = null)
    {
        if($actionId === null)
        {
            $actionId = $this->controller->defaultAction;
        }

        $this->controller->redirect(array($actionId));
    }

    /**
     * Renders view
     * By default renders same name view
     * @param array $data
     * @param boolean $return
     * @return string $render
    */

    public function render($data, $return = false)
    {
        if($this->_view === null)
        {
            $this->_view = $this->id;
        }

        return $this->controller->render($this->_view, $data, $return);
    }

    /**
	 * Performs the AJAX validation.
	 * @param CActiveRecord $model the model to be validated
	 */

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->modelName) . '-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * returns model with id or without id
     * uses YII component getter/setter magic
     * @param string $scenario scenario of model
     * @throws CHttpException
     * @return CActiveRecord $model
    */

    public function getModel($scenario = 'insert')
    {
        if(($id = Yii::app()->request->getParam('id')) === null)
        {
            $model = new $this->modelName($scenario);
        }
        else if(($model = CActiveRecord::model($this->modelName)->resetScope()->findByPk($id)) === null)
        {
            throw new CHttpException(404, Yii::t('base', 'The specified record cannot be found.'));
        }

        return $model;
    }

    /**
     * Returns model name
     * By default it's controller name
     * @return string $modelName
    */

    public function getModelName()
    {
        if($this->_modelName === null)
        {
            if($this->controller->id === 'admin') {

                $modelName = ucfirst($this->controller->action->id);

                $modelName = str_replace('Delete', '', $modelName);
                $modelName = str_replace('Update', '', $modelName);
                $modelName = str_replace('Create', '', $modelName);

                $this->_modelName = $modelName;
            }
            else {

                $this->_modelName = ucfirst($this->controller->id);
            }
        }

        return $this->_modelName;
    }

    /**
     * Setter for View
     * @param string $value
     * @return void
     */

    public function setView($value)
    {
        $this->_view = $value;
    }

    /**
     * Setter for model name
     * @param string $value
     * @return void
     */

    public function setModelName($value)
    {
        $this->_modelName = $value;
    }
}