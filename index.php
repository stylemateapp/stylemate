<?php
    assert_options(
        ASSERT_CALLBACK,
        function ($script, $line) {
            echo "assert failed file:$script line:$line ";
        }
    );

    require_once(dirname(__FILE__) . '/protected/components/helpers/EnvironmentHelper.php');

    EnvironmentHelper::setYiiDebugVariablesIfNeeded();

    $yii    = dirname(__FILE__) . '/framework/yii.php';
    $config = dirname(__FILE__) . '/protected/config/frontend.php';

    require_once($yii);

    Yii::createWebApplication($config)->runEnd('frontend');