<?php
/**
 * Controller class action for create category action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class CreateCategoryAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $model = new Category;

        if (isset($_POST['Category'])) {

            $model->attributes = $_POST['Category'];

            if ($model->save()) {

                $this->controller->setNotice('Category was successfully created');
                $this->controller->redirect($this->controller->createUrl('admin/category'));
            }
        }

        $this->controller->render(
            'category/create',
            array(
                 'model' => $model,
            )
        );
    }
}