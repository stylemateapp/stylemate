<?php
    /**
     * @var Controller $this
     * @var Category $model
     */
?>

<h1>Update Category <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('category/_form', array('model' => $model)); ?>