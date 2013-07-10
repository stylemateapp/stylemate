<?php
    /**
     * @var Controller   $this
     * @var ClothingType $model
     * @var TbActiveForm $form
     */
?>

<?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
             'id'                     => 'clothing-type-form',
             'enableClientValidation' => true,
             'clientOptions'          => array(
                 'validateOnSubmit' => true,
                 'validateOnChange' => true,
             ),
        )
    );
?>

    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>

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