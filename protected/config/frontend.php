<?php
    return CMap::mergeArray(
        require_once(dirname(__FILE__) . '/main.php'),
        array(
             'sourceLanguage' => 'en',
             'components'     => array(
                 'urlManager' => array(
                     'urlFormat'      => 'path',
                     'rules'          => array(
                         '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                         '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                         '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
                     ),
                     'showScriptName' => false,
                 ),
             ),
        )
    );

