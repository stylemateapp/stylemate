<?php
    $dbFile = dirname(__FILE__) . '/db.php';

    if (file_exists(dirname(__FILE__) . '/db-local.php')) {

        $dbFile = dirname(__FILE__) . '/db-local.php';
    }


    // This is the configuration for yiic console application.
    // Any writable CConsoleApplication properties can be configured here.
    return CMap::mergeArray(
        require_once($dbFile),
        array(
             'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
             'name'       => 'My Console Application',
             'commandMap' => array(
                 'migrate' => array(
                     'class'          => 'system.cli.commands.MigrateCommand',
                     'migrationPath'  => 'application.migrations',
                     'connectionID'   => 'db',
                 ),
             ),
        )
    );