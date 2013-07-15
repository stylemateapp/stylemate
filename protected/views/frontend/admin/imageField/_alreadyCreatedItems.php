<?php
    /**
     * @var ImageField[] $imageFields
     */
?>

<?php foreach($imageFields as $index => $imageField): ?>

    <?php
        echo CHtml::activeTextField(
            $imageField,
            "[$index]reference_url",
            array('placeholder' => 'Insert Reference URL', 'maxlength' => 255, 'class' => 'span4')
        );
    ?>

    <?php
        echo CHtml::activeTextField(
            $imageField,
            "[$index]reference_image",
            array('placeholder' => 'Insert URL of Image Thumbnail', 'maxlength' => 255, 'class' => 'span4')
        );
    ?>

    <?php
        echo CHtml::activeDropDownList(
            $imageField,
            "[$index]clothing_type",
            ClothingType::getListData(),
            array('placeholder' => 'Insert URL of Image Thumbnail', 'maxlength' => 255, 'class' => 'span3')
        );
    ?>

    <?php
        echo CHtml::ajaxButton(
            'Delete',
            $this->createUrl('/admin/imageFieldDelete', array('id' => $imageField->id)),
            array(
                 'type'    => 'POST',
                 'success' => 'function(html) {
                    location.reload();
                 }',
            ),
            array(
                 'class'   => 'btn btn-danger',
                 'confirm' => 'Are you sure you want to delete this image field?'
            )
        );
    ?>

    <div class="clearfix"></div>

<?php endforeach; ?>