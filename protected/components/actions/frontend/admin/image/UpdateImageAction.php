<?php
/**
 * Controller class action for update image action
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 * @property Controller $controller
 */

class UpdateImageAction extends Action
{
    /**
     * Main action method
     */

    public function run()
    {
        /**
         * @var Image $model
         */

        $model       = $this->getModel();
        $imageFields = $model->imageFields;

        if (isset($_POST['Image'])) {

            $model->attributes = $_POST['Image'];

            if ($model->save()) {

                if (isset($_POST['ImageField']['new'])) {

                    $imageField = new ImageField();
                    $imageField->attributes = $_POST['ImageField']['new'];
                    $imageField->image_id = $model->id;
                    $imageField->save();

                    $newImageFieldAdded = true;

                    $model->refresh();
                }

                if (isset($_POST['ImageField'])) {

                    $valid = true;

                    foreach ($imageFields as $i => $image) {

                        if (isset($_POST['ImageField'][$i])) {

                            $image->attributes = $_POST['ImageField'][$i];
                        }

                        $valid = $image->validate() && $valid;
                    }

                    if ($valid) {

                        if ($model->save()) {

                            $saveDone = true;

                            foreach ($imageFields as $image) {

                                $saveDone = $image->save() && $saveDone;
                            }

                            if ($saveDone) {

                                $this->controller->setNotice('Image was successfully updated');

                                if (isset($newImageFieldAdded)) {

                                    $this->controller->redirect(
                                        $this->controller->createUrl(
                                            'admin/imageUpdate',
                                            array('id' => $model->id)
                                        ) . '#imageFields'
                                    );
                                } else {

                                    $this->controller->redirect($this->controller->createUrl('admin/image'));
                                }
                            }
                        }
                    }
                }


            }
        }

        $this->controller->render(
            'image/update',
            array(
                 'model'       => $model,
                 'imageFields' => $imageFields,
            )
        );
    }
}