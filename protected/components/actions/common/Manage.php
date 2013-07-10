<?php

/**
 * Controller Action class for base manage modelName functionality
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2011 Smirnov Egor aka LastDay
 */

class Manage extends Action
{
    /**
	 * Manages all models.
	 */

    public function run()
	{
		$model = $this->getModel('search');
		$model->unsetAttributes();

        if (isset($_GET[$this->modelName])) {

            $model->attributes = $_GET[$this->modelName];
        }

		$this->controller->render(strtolower($this->modelName) . '/manage', array(
			'model' => $model,
		));
	}
}