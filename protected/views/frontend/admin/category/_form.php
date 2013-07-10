<?php
    /**
     * @var Controller   $this
     * @var Category     $model
     * @var TbActiveForm $form
     */
?>

<?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
             'id'                   => 'category-form',
             'enableAjaxValidation' => false,
        )
    );
?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->dropDownListRow($model, 'category_group_id', CategoryGroup::getListData(), array('class' => 'span5')); ?>

    <div class="form-actions">
        <?php
            $this->widget(
                'bootstrap.widgets.TbButton',
                array(
                     'buttonType' => 'submit',
                     'type'       => 'primary',
                     'label'      => $model->isNewRecord ? 'Create' : 'Save',
                )
            );
        ?>
    </div>

<?php $this->endWidget(); ?>