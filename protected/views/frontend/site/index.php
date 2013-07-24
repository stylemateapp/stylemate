<?php
    /**
     * @var Controller $this
     */
?>

<?php $this->pageTitle = Yii::app()->name; ?>

<div>
    <?php echo CHtml::link('Go to admin panel', $this->createUrl('admin/index')); ?> <br>
    <?php echo CHtml::link('Logout', $this->createUrl('site/logout')); ?>
</div>