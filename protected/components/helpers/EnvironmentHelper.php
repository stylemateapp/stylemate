<?php

/**
 * Class for environment-related helper functions
 *
 * @author    Smirnov Egor <egorsmir@gmail.com>
 * @link      http://lastdayz.ru
 * @copyright Copyright &copy; 2013 Smirnov Egor aka LastDay
 *
 */

class EnvironmentHelper
{
    /**
     * @return string
     */

    public static function returnCurrentEnvironment()
    {
        $environment = 'production';

        if (file_exists(dirname(__FILE__) . '/../../config/environment.php')) {

            $environment = require_once(dirname(__FILE__) . '/../../config/environment.php');
        }

        return $environment;
    }

    /**
     *
     */

    public static function setYiiDebugVariablesIfNeeded()
    {
        if (self::returnCurrentEnvironment() === 'debug') {

            defined('YII_DEBUG') or define('YII_DEBUG', true);
            defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
        }
    }
}