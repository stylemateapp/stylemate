<?php
/**
 * Controller class action for update clothing type action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class UpdateClothingTypeAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        $model = $this->getModel();

        if (isset($_POST['ClothingType'])) {

            $model->attributes = $_POST['ClothingType'];

            if ($model->save()) {

                $this->controller->setNotice('Clothing Type was successfully updated');
                $this->controller->redirect($this->controller->createUrl('admin/clothingType'));
            }
        }

        $this->controller->render(
            'clothingtype/update',
            array(
                 'model' => $model,
            )
        );
    }
}