<?php
    /**
     * @var Controller $this
     */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="language" content="en">
    <meta charset="utf-8">

    <?php
        Yii::app()->clientScript->scriptMap = array('jquery.js' => false);
    ?>

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app-admin.css">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/magicsuggest-1.3.0-min.css">
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/jquery-1.8.3-min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/magicsuggest-1.3.0-min.js"></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <header id="overview" class="jumbotron subhead">
        <div class="container">
            <h1>Stylemate Admin Panel</h1>
        </div>
    </header>

    <nav class="container">
        <?php
            $this->widget(
                'zii.widgets.CMenu',
                array(
                     'items'       => array(
                         array('label' => 'Admin Home', 'url' => array('admin/index')),
                         array('label' => 'Images', 'url' => array('admin/image')),
                         array('label' => 'Categories', 'url' => array('admin/category')),
                         array('label' => 'Clothing Types', 'url' => array('admin/clothingType')),
                         array('label' => 'Logout', 'url' => array('site/logout')),
                     ),
                     'htmlOptions' => array(
                         'class' => 'nav nav-pills',
                     ),
                )
            );
        ?>
    </nav>

    <div class="container">
        <?php $this->printAllFlashes(); ?>
    </div>

    <div class="container">
        <?php echo $content; ?>
    </div>

    <footer class="container">
        Developed by <a href="http://lastdayz.ru" target="_blank">Smirnov Egor</a>
    </footer>
</body>
</html>