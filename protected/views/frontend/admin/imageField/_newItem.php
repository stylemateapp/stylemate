<?php
    $imageField = new ImageField();
?>

<div class="clearfix"></div>

<?php
    echo CHtml::activeTextField(
        $imageField,
        "[new]reference_url",
        array('placeholder' => 'Insert Reference URL', 'maxlength' => 255, 'class' => 'span4')
    );
?>

<?php
    echo CHtml::activeTextField(
        $imageField,
        "[new]reference_image",
        array('placeholder' => 'Insert URL of Image Thumbnail', 'maxlength' => 255, 'class' => 'span4')
    );
?>

<?php
    echo CHtml::activeDropDownList(
        $imageField,
        "[new]clothing_type",
        ClothingType::getListData(),
        array('placeholder' => 'Insert URL of Image Thumbnail', 'maxlength' => 255, 'class' => 'span3')
    );
?>

<button name="add-new-image-field" type="button" class="btn btn-primary" id="add-new-image-reference">Add</button>

<div class="clearfix"></div>

<script type="text/javascript">

    $('#add-new-image-reference').click(function() {

        var valid = true;

        if ($('#ImageField_new_reference_url').val() == '') {

            valid = false;
            alert('Reference URL cannot be empty');
        }

        if ($('#ImageField_new_reference_image').val() == '') {

            valid = false;
            alert('URL of Image Thumbnail cannot be empty');
        }

        if (valid) {

            $('#image-form').submit();
        }
    });

</script>