<?php
    /**
     * @var Controller  $this
     * @var LoginForm   $model
     * @var CActiveForm $form
     */

    $this->pageTitle = Yii::app()->name . ' - Login';
    $this->breadcrumbs = array(
        'Login',
    );
?>

<h1>Login</h1>

<div class="form">

    <?php
        $form = $this->beginWidget(
            'CActiveForm',
            array(
                 'id'                     => 'login-form',
                 'enableClientValidation' => true,
                 'focus'                  => array($model, 'email'),
                 'htmlOptions'            => array('class' => 'form-horizontal'),
                 'clientOptions' => array(
                     'validateOnSubmit' => true,
                     'validateOnChange' => true,
                 ),
            )
        );
    ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'control-label', 'placeholder' => 'Email')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'password', array('class' => 'control-label', 'placeholder' => 'Password')); ?>
        <div class="controls">
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <?php echo $form->checkBox($model, 'rememberMe'); ?> Remember me
            </label>
            <button type="submit" class="btn">Login</button>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>
