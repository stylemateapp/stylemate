<?php
    /**
     * @var Controller $this
     * @var Category $model
     */
?>

<h1>Categories</h1>

<div class="well">

    <?php
        echo CHtml::link(
            'Create New Category',
            $this->createUrl('admin/categoryCreate'),
            array('class' => 'btn btn-primary')
        );
    ?>

</div>

<?php
    $this->widget(
        'bootstrap.widgets.TbGridView',
        array(
             'id'           => 'category-grid',
             'dataProvider' => $model->search(),
             'filter'       => $model,
             'template'     => "{items}\n{pager}",
             'type'         => 'striped bordered condensed',
             'columns'      => array(
                 'id',
                 array(
                     'name'   => 'name',
                     'type'   => 'raw',
                     'header' => 'Category Name',
                     'value'  => 'CHtml::link($data->name, Yii::app()->controller->createUrl("admin/categoryUpdate/", array("id" => $data->id)))',
                 ),
                 array(
                     'name'   => 'category_group_id',
                     'header' => 'Category Group',
                     'filter' => CategoryGroup::getListData(),
                     'value'  => '$data->categoryGroup->name',
                 ),
                 array(
                     'class'    => 'bootstrap.widgets.TbButtonColumn',
                     'template' => '{update}{delete}',
                     'buttons'  => array(
                         'update' => array(
                             'url' => 'Yii::app()->controller->createUrl("admin/categoryUpdate", array("id" => $data[id]))',
                         ),
                         'delete' => array(
                             'url' => 'Yii::app()->controller->createUrl("admin/categoryDelete", array("id" => $data[id]))',
                         ),
                     ),
                 ),
             ),
        )
    );
?>
