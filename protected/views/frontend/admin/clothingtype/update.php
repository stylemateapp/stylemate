<?php
    /**
     * @var Controller $this
     * @var ClothingType $model
     */
?>

<h1>Update Clothing Type <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('clothingtype/_form', array('model' => $model)); ?>