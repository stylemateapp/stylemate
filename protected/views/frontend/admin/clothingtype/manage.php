<?php
    /**
     * @var Controller $this
     * @var ClothingType $model
     */
?>

<h1>Clothing Types</h1>

<div class="well">

    <?php
        echo CHtml::link(
            'Create New Clothing Type',
            $this->createUrl('admin/clothingTypeCreate'),
            array('class' => 'btn btn-primary')
        );
    ?>

</div>

<?php
    $this->widget(
        'bootstrap.widgets.TbGridView',
        array(
             'id'           => 'clothing-type-grid',
             'dataProvider' => $model->search(),
             'filter'       => $model,
             'template'     => "{items}\n{pager}",
             'columns'      => array(
                 'id',
                 array(
                     'name'   => 'name',
                     'type'   => 'raw',
                     'header' => 'Clothing Type Name',
                     'value'  => 'CHtml::link($data->name, Yii::app()->controller->createUrl("admin/clothingTypeUpdate/", array("id" => $data->id)))',
                 ),
                 array(
                     'class'    => 'bootstrap.widgets.TbButtonColumn',
                     'template' => '{update}{delete}',
                     'buttons'  => array(
                         'update' => array(
                             'url' => 'Yii::app()->controller->createUrl("admin/clothingTypeUpdate", array("id" => $data[id]))',
                         ),
                         'delete' => array(
                             'url' => 'Yii::app()->controller->createUrl("admin/clothingTypeDelete", array("id" => $data[id]))',
                         ),
                     ),

                 ),
             ),
        )
    );
?>
