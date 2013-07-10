<?php

    $dbFile = dirname(__FILE__) . '/db.php';

    if (file_exists(dirname(__FILE__) . '/db-local.php')) {

        $dbFile = dirname(__FILE__) . '/db-local.php';
    }

   // uncomment the following to define a path alias
   // Yii::setPathOfAlias('local','path/to/local-folder');

    Yii::setPathOfAlias('backendControllers', dirname(__FILE__) . '/../controllers/backend/');

    // This is the main Web application configuration. Any writable
    // CWebApplication properties can be configured here.
    return CMap::mergeArray(
        require_once($dbFile),
        array(
             'basePath'      => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
             'name'          => 'Stylemate',
             'behaviors'     => array(
                 'runEnd' => array(
                     'class' => 'application.components.behaviors.WebApplicationEndBehavior'
                 ),
             ),
             'controllerMap' => array(

             ),
             // autoloading model and component classes
             'import'        => array(
                 'application.models.*',
                 'application.components.*',
                 'application.components.system.*',
                 'application.components.actions.common.*',
                 'application.components.widgets.*',
                 'application.components.helpers.*'
             ),
             'modules'       => array(
                 // uncomment the following to enable the Gii tool
                 'gii' => array(
                     'class'     => 'system.gii.GiiModule',
                     'password'  => 'admin123',
                     // If removed, Gii defaults to localhost only. Edit carefully to taste.
                     //'ipFilters' => array('95.79.50.171', '::1'),
                 ),
             ),
             'language'      => 'en',
             // preloading 'log' component
             'preload'       => array('log'),
             // application components
             'components'    => array(

                 'user'         => array(
                     // enable cookie-based authentication
                     'class'            => 'WebUser',
                     'allowAutoLogin'   => true,
                     'loginUrl'         => array('/site/login'),
                     'adminRedirectUrl' => array('/admin/index'),
                 ),
                 // uncomment the following to use a MySQL database
                 'authManager'  => array(
                     'class'        => 'PhpAuthManager',
                     'defaultRoles' => array('guest'),
                 ),
                 'errorHandler' => array(
                     // use 'site/error' action to display errors
                     'errorAction' => 'site/error',
                 ),
                 'log'          => array(
                     'class'  => 'CLogRouter',
                     'routes' => array(
                         array(
                             'class'  => 'CFileLogRoute',
                             'levels' => 'error, warning',
                         ),

                         // you could comment out this section for dev. mode

                         /*array(
                             'class'      => 'CEmailLogRoute',
                             'levels'     => 'error, warning, trace, profile, info',

                             // shouldn't contain any adresses in dev. mode
                             // should contain addresses for emails in production mode

                             'emails'     => array('beta@humaneos.com'),
                             'sentFrom'   => '"Humaneos" <beta@humaneos.com;> ',
                             'subject'    => 'Error at humaneos'
                         ),*/
                         /*array(
                             'class' => 'CProfileLogRoute',
                             'levels' => 'profile',
                             'enabled' => true,
                         )*/
                     ),
                 ),
                 'session'      => array(
                     'class'                  => 'application.components.system.MyCDbHttpSession',
                     'connectionID'           => 'db',
                     'sessionTableName'       => 'sessions',
                     'autoCreateSessionTable' => false,
                     'timeout'                => 10000000,
                     'cookieParams'           => array(
                         //'domain' => 'http://google.ru',
                         /*'lifetime'=> REMEMBER_ME_EXPIRE,*/
                     ),
                     'compareIpAddress'       => true,
                     'compareUserAgent'       => true,
                     'compareIpBlocks'        => 2,
                 )
             ),
             // application-level parameters that can be accessed
             // using Yii::app()->params['paramName']
             'params'        => require_once(dirname(__FILE__) . '/params.php'),
        )
    );