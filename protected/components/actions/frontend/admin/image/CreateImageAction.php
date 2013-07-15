<?php
/**
 * Controller class action for create image action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class CreateImageAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $model = new Image();

        if (isset($_POST['Image'])) {

            $model->attributes = $_POST['Image'];

            if ($model->save()) {

                $this->controller->setNotice('Image was successfully created');
                $this->controller->redirect($this->controller->createUrl('admin/image'));
            }
        }

        $this->controller->render(
            'image/create',
            array(
                 'model' => $model,
            )
        );
    }
}