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

<div class="container">

    <div>
        <?php $this->printAllFlashes(); ?>
    </div>

    <?php echo $content; ?>

</div>
</body>
</html>