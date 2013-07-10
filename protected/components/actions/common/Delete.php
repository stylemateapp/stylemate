<?php

/**
 * Controller Action class for base delete modelName functionality
 *
 * @author Smirnov Egor <egorsmir@gmail.com>
 * @link http://lastdayz.ru
 * @copyright Copyright &copy; 2011 Smirnov Egor aka LastDay
 */

 
class Delete extends Action 
{
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @throws CHttpException
     *
     * @param integer $id the ID of the model to be deleted
     */

    public function run($id)
    {
        if (Yii::app()->request->isPostRequest) {

            // we only allow deletion via POST request

            $this->getModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

            if (!isset($_GET['ajax'])) {

                $this->controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {

            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}