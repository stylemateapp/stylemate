<?php
    /**
     * @var Controller $this
     * @var Image $model
     */
?>

<h1>Images</h1>

<div class="well">

    <?php
        echo CHtml::link(
            'Create New Image',
            $this->createUrl('admin/imageCreate'),
            array('class' => 'btn btn-primary')
        );
    ?>

</div>

<?php
    $this->widget(
        'bootstrap.widgets.TbGridView',
        array(
             'id'           => 'image-grid',
             'dataProvider' => $model->search(),
             'filter'       => $model,
             'template'     => "{items}\n{pager}",
             'type'         => 'striped bordered condensed',
             'columns'      => array(
                 'id',
                 array(
                     'name'   => 'name',
                     'type'   => 'raw',
                     'header' => 'Image File',
                     'value'  => 'CHtml::link(CHtml::image($data->imageUrl, "", array("width" => "150")), Yii::app()->controller->createUrl("admin/imageUpdate/", array("id" => $data->id)))',
                 ),
                 array(
                     'name'   => 'categoriesStyleList',
                     'header' => 'Styles',
                 ),
                 array(
                     'name'   => 'categoriesWeatherList',
                     'header' => 'Weather',
                 ),
                 array(
                     'name'   => 'categoriesOccasionList',
                     'header' => 'Occasions',
                 ),
                 array(
                     'class'    => 'bootstrap.widgets.TbButtonColumn',
                     'template' => '{update}{delete}',
                     'buttons'  => array(
                         'update' => array(
                             'url' => 'Yii::app()->controller->createUrl("admin/imageUpdate", array("id" => $data[id]))',
                         ),
                         'delete' => array(
                             'url' => 'Yii::app()->controller->createUrl("admin/imageDelete", array("id" => $data[id]))',
                         ),
                     ),
                 ),
             ),
        )
    );
?>
