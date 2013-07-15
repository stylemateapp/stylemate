<?php
    /**
     * @var Controller   $this
     * @var Image        $model
     * @var ImageField[] $imageFields
     * @var TbActiveForm $form
     */
?>

<?php
    $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
             'id'                     => 'image-form',
             'htmlOptions' => array(
                 'enctype' => 'multipart/form-data',
             ),
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

    <?php if (!$model->isNewRecord): ?>

        <?php echo $form->errorSummary($imageFields); ?>

    <?php endif; ?>

    <?php echo $form->fileFieldRow($model, 'name'); ?>

    <?php if (!$model->isNewRecord): ?>

        <div class="well">
            <?php echo CHtml::link(CHtml::image($model->imageUrl, "", array("width" => "150")), $model->imageUrl); ?>
        </div>

    <?php endif; ?>

    <div class="well">
        <label>Select Style(s)</label>
        <div id="image-categories-styles"></div>
        <script>
            $('#image-categories-styles').magicSuggest({
                name: 'Image[categories][]',
                displayField: 'name',
                allowFreeEntries: false,
                data: [

                    <?php foreach(Category::getCategoriesByGroup(Yii::app()->params['styleGroupId']) as $category): ?>

                        {
                            id: <?php echo $category->id; ?>,
                            name: '<?php echo $category->name; ?>'
                        },

                    <?php endforeach; ?>

                ],
                value: [

                    <?php foreach($model->categoriesStyle as $category): ?>

                        <?php echo $category->id; ?>,

                    <?php endforeach; ?>

                ]
            });
        </script>
    </div>

    <div class="well">
        <label>Select Weather(s)</label>
        <div id="image-categories-weathers"></div>
        <script>
            $('#image-categories-weathers').magicSuggest({
                name: 'Image[categories][]',
                displayField: 'name',
                allowFreeEntries: false,
                data: [

                    <?php foreach(Category::getCategoriesByGroup(Yii::app()->params['weatherGroupId']) as $category): ?>

                        {
                            id: <?php echo $category->id; ?>,
                            name: '<?php echo $category->name; ?>'
                        },

                    <?php endforeach; ?>

                ],
                value: [

                    <?php foreach($model->categoriesWeather as $category): ?>

                        <?php echo $category->id; ?>,

                    <?php endforeach; ?>

                ]
            });
        </script>
    </div>

    <div class="well">
        <label>Select Occasion(s)</label>
        <div id="image-categories-occasions"></div>
        <script>
            $('#image-categories-occasions').magicSuggest({
                name: 'Image[categories][]',
                displayField: 'name',
                allowFreeEntries: false,
                data: [

                    <?php foreach(Category::getCategoriesByGroup(Yii::app()->params['occasionGroupId']) as $category): ?>

                        {
                            id: <?php echo $category->id; ?>,
                            name: '<?php echo $category->name; ?>'
                        },

                    <?php endforeach; ?>

                ],
                value: [

                    <?php foreach($model->categoriesOccasion as $category): ?>

                        <?php echo $category->id; ?>,

                    <?php endforeach; ?>

                ]
            });
        </script>
    </div>

    <?php if (!$model->isNewRecord): ?>

        <?php if (!empty($imageFields)): ?>

            <a name="imageFields"></a>

            <div class="well">

                <?php $this->renderPartial('imageField/_alreadyCreatedItems', array('imageFields' => $imageFields)); ?>

            </div>

        <?php endif; ?>

        <div class="well">
            Add new reference:

            <?php $this->renderPartial('imageField/_newItem'); ?>
        </div>

    <?php endif; ?>

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