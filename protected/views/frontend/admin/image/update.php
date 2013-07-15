<?php
    /**
     * @var Controller $this
     * @var Image $model
     * @var ImageField[] $imageFields
     */
?>

<h1>Update Image <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('image/_form', array('model' => $model, 'imageFields' => $imageFields)); ?>