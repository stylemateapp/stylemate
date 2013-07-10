<?php
/**
 * Controller class action for create clothing type action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class CreateClothingTypeAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $model = new ClothingType();

        if (isset($_POST['ClothingType'])) {

            $model->attributes = $_POST['ClothingType'];

            if ($model->save()) {

                $this->controller->setNotice('Clothing Type was successfully created');
                $this->controller->redirect($this->controller->createUrl('admin/clothingType'));
            }
        }

        $this->controller->render(
            'clothingtype/create',
            array(
                 'model' => $model,
            )
        );
    }
}