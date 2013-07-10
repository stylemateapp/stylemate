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

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <header id="overview" class="jumbotron subhead">
        <div class="container">
            <h1>Stylemate Admin Panel</h1>

            <p class="lead">Here it's possible to add / update images etc.</p>
        </div>
    </header>

    <nav class="container">
        <ul class="nav nav-pills">
            <li class="active">
                <?php echo CHtml::link('Admin Home', $this->createUrl('admin/index')); ?>
            </li>
            <li>
                <?php echo CHtml::link('Logout', $this->createUrl('site/logout')); ?>
            </li>
        </ul>
    </nav>

    <div class="container">
        <?php $this->printAllFlashes(); ?>
    </div>

    <div class="container">
        <?php echo $content; ?>
    </div>
</body>
</html>