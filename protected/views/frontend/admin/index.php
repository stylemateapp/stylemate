<?php
    /**
     * @var Controller $this
     */
?>

<?php $this->pageTitle = Yii::app()->name; ?>

<div class="well">
    <ul class="nav nav-list">
        <li class="active">
            <?php echo CHtml::link('Admin Home', $this->createUrl('admin/index')); ?>
        </li>
        <li>
            <?php echo CHtml::link('Images', $this->createUrl('admin/image')); ?>
        </li>
        <li>
            <?php echo CHtml::link('Categories', $this->createUrl('admin/category')); ?>
        </li>
        <li>
            <?php echo CHtml::link('Clothing Types', $this->createUrl('admin/clothingType')); ?>
        </li>
        <li>
            <?php echo CHtml::link('Logout', $this->createUrl('site/logout')); ?>
        </li>
    </ul>
</div>